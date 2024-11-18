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
        if ($this->limiter->tooManyAttempts($this->throttleKey($request), 10)) {
            return back()->withErrors(['email' => 'Too many verification requests. Please try again in an hour.']);
        }

        $this->limiter->hit($this->throttleKey($request), 3600);

        return $next($request);
    }

    protected function throttleKey(Request $request): string
    {
        return 'verification:' . $request->ip();
    }
}