<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        if ($request->user() &&
            !$request->user()->verified &&
            !$request->is('email/*', 'logout')
        ) {
            return Redirect::route('verification.notice');
        }

        return $next($request);
    }


}