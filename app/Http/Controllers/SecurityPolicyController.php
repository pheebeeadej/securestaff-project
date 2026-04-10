<?php

namespace App\Http\Controllers;

use App\Models\PasswordPolicy;
use App\Models\SecurityEvent;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SecurityPolicyController extends Controller
{
    public function index(): View
    {
        return view('admin.security.policies', [
            'policy' => PasswordPolicy::query()->where('enabled', true)->latest()->first(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'min_length' => ['required', 'integer', 'min:8', 'max:64'],
            'history_depth' => ['required', 'integer', 'min:1', 'max:24'],
            'expiry_days' => ['required', 'integer', 'min:30', 'max:365'],
            'lockout_threshold' => ['required', 'integer', 'min:3', 'max:10'],
            'require_uppercase' => ['nullable', 'boolean'],
            'require_lowercase' => ['nullable', 'boolean'],
            'require_numeric' => ['nullable', 'boolean'],
            'require_symbol' => ['nullable', 'boolean'],
        ]);

        $data['enabled'] = true;
        PasswordPolicy::query()->update(['enabled' => false]);
        PasswordPolicy::create($data);

        return back()->with('status', 'Password policy updated successfully.');
    }

    public function dashboard(): View
    {
        return view('admin.security.dashboard', [
            'recentEvents' => SecurityEvent::latest()->take(25)->get(),
            'lockedUsers' => User::whereNotNull('locked_until')->where('locked_until', '>', now())->count(),
            'policyViolations' => SecurityEvent::whereIn('event_type', ['password_rejected', 'password_policy_violation'])->count(),
        ]);
    }
}
