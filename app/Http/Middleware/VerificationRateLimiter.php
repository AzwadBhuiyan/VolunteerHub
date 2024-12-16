<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificationRateLimiter
{
    public function __construct(protected RateLimiter $limiter)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'verification:'.$request->ip();
        
        if ($this->limiter->tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'email' => 'Too many verification attempts. Please try again later.'
            ]);
        }

        $this->limiter->hit($key, 60 * 24); // 24 hour window

        return $next($request);
    }
}