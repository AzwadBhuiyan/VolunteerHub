<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Activity;

class CheckActivityStatus
{
    public function handle(Request $request, Closure $next)
    {
        \Log::info('Middleware triggered for path: ' . $request->path());
        \Log::info('Checking activity statuses...');
        Activity::where('status', 'open')->get()->each(function ($activity) {
            if ($activity->shouldBeClosed()) {
                \Log::info("Closing activity {$activity->activityid}");
                $activity->close();
            }
        });

        return $next($request);
    }
}