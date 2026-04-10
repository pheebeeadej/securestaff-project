<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewUserCredentialsNotification;
use App\Services\PasswordPolicyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            $user->notify(new NewUserCredentialsNotification($request->user(), $data['password']));
        } catch (\Throwable) {
            $status = 'User created, but credentials email could not be sent. Check mail settings.';
        }

        return back()->with('status', $status);
    }
}
