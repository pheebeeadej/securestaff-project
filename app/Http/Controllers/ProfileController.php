<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile.index', [
            'user' => auth()->user(),
        ]);
    }

    public function updateTwoFactor(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'enabled' => ['required', 'boolean'],
        ]);

        $request->user()->forceFill([
            'two_factor_enabled' => (bool) $data['enabled'],
        ])->save();

        return back()->with('status', $data['enabled'] ? 'Email 2FA enabled.' : 'Email 2FA disabled.');
    }
}
