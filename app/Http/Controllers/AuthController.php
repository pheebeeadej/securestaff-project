<?php

namespace App\Http\Controllers;

use App\Models\SecurityEvent;
use App\Models\User;
use App\Notifications\TwoFactorCodeNotification;
use App\Services\PasswordPolicyService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private readonly PasswordPolicyService $passwordPolicyService)
    {
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        $policy = $this->passwordPolicyService->activePolicy();

        $user = User::query()->where('email', $credentials['email'])->first();

        if ($user && $user->locked_until && $user->locked_until->isFuture()) {
            return back()->withErrors([
                'email' => 'Your account is temporarily locked. Try again after '.$user->locked_until->format('H:i'),
            ]);
        }

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            if ($user) {
                $user->increment('failed_login_attempts');

                if ($user->failed_login_attempts >= (int) $policy->lockout_threshold) {
                    $user->forceFill([
                        'locked_until' => now()->addMinutes(15),
                    ])->save();
                }

                SecurityEvent::create([
                    'user_id' => $user->id,
                    'event_type' => 'failed_login',
                    'severity' => 'high',
                    'description' => 'Invalid login credentials supplied.',
                    'ip_address' => $request->ip(),
                    'meta' => ['attempts' => $user->failed_login_attempts],
                ]);
            }

            return back()->withErrors([
                'email' => 'Invalid login credentials.',
            ]);
        }

        $request->session()->put('auth.pending_user_id', $user->id);
        $request->session()->forget([
            'auth.2fa_code_hash',
            'auth.2fa_expires_at',
        ]);

        if ($user->two_factor_enabled) {
            return $this->sendTwoFactorCodeAndRedirect($request, $user);
        }

        return $this->completeAuthenticatedSession($request, $user);
    }

    public function showTwoFactorChallenge(Request $request): View|RedirectResponse
    {
        $user = $this->pendingUser($request);

        if (! $user || ! $user->two_factor_enabled) {
            return redirect()->route('login');
        }

        return view('auth.two-factor', [
            'email' => $user->email,
        ]);
    }

    public function verifyTwoFactorChallenge(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);
        $user = $this->pendingUser($request);

        if (! $user || ! $user->two_factor_enabled) {
            return redirect()->route('login');
        }

        $expiresAt = $request->session()->get('auth.2fa_expires_at');
        $codeHash = $request->session()->get('auth.2fa_code_hash');

        if (! $codeHash || ! $expiresAt || now()->greaterThan(Carbon::parse($expiresAt))) {
            return back()->withErrors([
                'code' => 'Verification code expired. Please login again to receive a new code.',
            ]);
        }

        if (! Hash::check($data['code'], $codeHash)) {
            return back()->withErrors([
                'code' => 'Invalid verification code.',
            ]);
        }

        return $this->completeAuthenticatedSession($request, $user);
    }

    public function resendTwoFactorCode(Request $request): RedirectResponse
    {
        $user = $this->pendingUser($request);

        if (! $user || ! $user->two_factor_enabled) {
            return redirect()->route('login');
        }

        return $this->sendTwoFactorCodeAndRedirect($request, $user, 'A new verification code has been sent to your email.');
    }

    public function showChangePassword(): View
    {
        return view('security.change-password', [
            'policy' => $this->passwordPolicyService->activePolicy(),
        ]);
    }

    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $this->passwordPolicyService->rotatePassword($request->user(), $request->string('password')->toString());

        return redirect()->route('dashboard')->with('status', 'Password updated successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->clearPendingAuth($request);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function sendTwoFactorCodeAndRedirect(
        Request $request,
        User $user,
        string $statusMessage = 'A verification code was sent to your email.'
    ): RedirectResponse {
        $code = (string) random_int(100000, 999999);
        $request->session()->put('auth.2fa_code_hash', Hash::make($code));
        $request->session()->put('auth.2fa_expires_at', now()->addMinutes(10)->toIso8601String());

        try {
            $user->notify(new TwoFactorCodeNotification($code));
        } catch (\Throwable $exception) {
            Log::error('Unable to send 2FA code email.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'message' => $exception->getMessage(),
            ]);

            if (app()->environment('local')) {
                return redirect()->route('auth.2fa.challenge')
                    ->with('status', 'Mail delivery failed. Development fallback code: '.$code);
            }

            $this->clearPendingAuth($request);

            return redirect()->route('login')->withErrors([
                'email' => 'Unable to send verification code. Please contact support.',
            ]);
        }

        if (app()->environment('local')) {
            $statusMessage .= ' Development code: '.$code;
        }

        return redirect()->route('auth.2fa.challenge')->with('status', $statusMessage);
    }

    private function completeAuthenticatedSession(Request $request, User $user): RedirectResponse
    {
        $user->forceFill([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ])->save();

        Auth::login($user);
        $request->session()->regenerate();
        $this->clearPendingAuth($request);

        if ($user->must_change_password || $this->passwordPolicyService->passwordExpired($user)) {
            return redirect()->route('security.change-password')
                ->with('status', 'You must change your password before continuing.');
        }

        return redirect()->route('dashboard');
    }

    private function pendingUser(Request $request): ?User
    {
        $pendingUserId = $request->session()->get('auth.pending_user_id');

        if (! $pendingUserId) {
            return null;
        }

        return User::query()->find($pendingUserId);
    }

    private function clearPendingAuth(Request $request): void
    {
        $request->session()->forget([
            'auth.pending_user_id',
            'auth.2fa_code_hash',
            'auth.2fa_expires_at',
        ]);
    }
}
