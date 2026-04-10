<?php

namespace App\Http\Middleware;

use App\Services\PasswordPolicyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    public function __construct(private readonly PasswordPolicyService $passwordPolicyService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->must_change_password || $this->passwordPolicyService->passwordExpired($user)) {
            return redirect()->route('security.change-password')
                ->with('status', 'Password must be updated before accessing the application.');
        }

        return $next($request);
    }
}
