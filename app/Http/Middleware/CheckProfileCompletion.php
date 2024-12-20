<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if ($user->volunteer && $user->volunteer->getProfileCompletionPercentage() < 100) {
            return redirect()->back()->with('error', 'Please complete your profile before registering for activities.');
        }
        
        if ($user->organization && $user->organization->getProfileCompletionPercentage() < 100) {
            return redirect()->back()->with('error', 'Please complete your organization profile before creating activities.');
        }

        return $next($request);
    }
}