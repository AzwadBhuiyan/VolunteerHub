<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\TwoFactorCode;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->two_factor_enabled) {
            // If we're on the verification page and have a login attempt in progress, allow it
            if ($request->is('2fa/*') && session()->has('auth.login')) {
                return $next($request);
            }

            // If we have verified 2FA, allow the request
            if (session()->has('two_factor_verified')) {
                return $next($request);
            }

            // Otherwise, log them out
            auth()->logout();
            session()->flush();
            return redirect()->route('login')
                ->withErrors(['email' => 'Please complete the two-factor authentication.']);
        }

        return $next($request);
    }
}