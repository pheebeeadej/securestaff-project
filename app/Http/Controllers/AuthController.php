<?php

namespace App\Http\Controllers;

use App\Models\SecurityEvent;
use App\Models\User;
use App\Services\PasswordPolicyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $user->forceFill([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ])->save();

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->must_change_password || $this->passwordPolicyService->passwordExpired($user)) {
            return redirect()->route('security.change-password')
                ->with('status', 'You must change your password before continuing.');
        }

        return redirect()->route('dashboard');
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
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
