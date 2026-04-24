<?php

namespace App\Http\Controllers;

use App\Mail\GeneralMail;
use App\Models\User;
use App\Services\PasswordPolicyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    private const DEPARTMENTS = [
        'Human Resources',
        'Information Technology',
        'Finance',
        'Operations',
        'Marketing',
        'Sales',
    ];

    public function __construct(private readonly PasswordPolicyService $passwordPolicyService)
    {
    }

    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->latest()->get(),
            'departments' => self::DEPARTMENTS,
            'policy' => $this->passwordPolicyService->activePolicy(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'department' => ['required', Rule::in(self::DEPARTMENTS)],
            'role' => ['required', 'in:admin,employee'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $this->passwordPolicyService->assertPasswordMeetsPolicy($data['password']);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'department' => $data['department'],
            'role' => $data['role'], 
            'password' => Hash::make($data['password']),
            'must_change_password' => true,
            'password_changed_at' => null,
            'failed_login_attempts' => 0,
            'locked_until' => null,
            'two_factor_enabled' => true,
        ]);

        $status = 'User created successfully. Credentials email sent.';

        try {
            Log::info('mail_credentials_attempt', [
                'created_user_id' => $user->id,
                'created_user_email' => $user->email,
                'created_by_user_id' => $request->user()?->id,
            ]);

            Mail::to($user->email)->send(new GeneralMail(
                subject: 'Your SecureStaff account details',
                messageBody: implode("\n", [
                    'An account has been created for you on SecureStaff.',
                    'Email: '.$user->email,
                    'Temporary password: '.$data['password'],
                    'Role: '.$user->role,
                    'Department: '.($user->department ?: 'N/A'),
                    'For security, you must change your password immediately after first login.',
                    'Created by: '.$request->user()->name,
                ]),
                name: $user->name,
                heading: 'Welcome to SecureStaff',
                bannerTitle: 'Account Created',
                bannerSubtitle: 'Your SecureStaff credentials',
                bannerIcon: '🔐',
                buttonText: 'Login to SecureStaff',
                buttonUrl: url('/login')
            ));

            Log::info('mail_credentials_sent', [
                'created_user_id' => $user->id,
                'created_user_email' => $user->email,
            ]);
        } catch (\Throwable $exception) {
            Log::error('Unable to send new user credentials email.', [
                'created_user_id' => $user->id,
                'created_user_email' => $user->email,
                'created_by_user_id' => $request->user()?->id,
                'created_by_email' => $request->user()?->email,
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
            ]);

            $status = 'User created, but credentials email could not be sent. Check mail settings.';
        }

        return back()->with('status', $status);
    }
}
