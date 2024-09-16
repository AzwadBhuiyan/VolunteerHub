<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Activity;

class CheckActivityStatus
{
    public function handle(Request $request, Closure $next)
    {
        Activity::where('status', 'open')->get()->each(function ($activity) {
            if ($activity->shouldBeClosed()) {
                $activity->close();
            }
        });

        return $next($request);
    }
}