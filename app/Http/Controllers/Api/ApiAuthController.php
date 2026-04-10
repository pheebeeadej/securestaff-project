<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PasswordPolicyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function __construct(private readonly PasswordPolicyService $passwordPolicyService)
    {
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        abort_unless($user && Hash::check($request->password, $user->password), 422, 'Invalid credentials.');
        abort_if($user->locked_until && $user->locked_until->isFuture(), 423, 'Account is temporarily locked.');
        abort_if(
            $user->must_change_password || $this->passwordPolicyService->passwordExpired($user),
            403,
            'Password change required before API access.'
        );

        $user->forceFill([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ])->save();

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Token revoked.']);
    }
}
