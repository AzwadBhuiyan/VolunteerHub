<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Activity;
use App\Models\Volunteer;
use App\Models\Organization;

class HomeController extends Controller
{
    public function index(): View
    {
        $totalHours = Activity::where('status', 'completed')->sum('duration');
        $totalVolunteers = Volunteer::whereHas('user', function($query) {
            $query->where('verified', true);
        })->count();
        $totalCompletedActivities = Activity::where('status', 'completed')->count();

        $activities = Activity::with('organization')
            ->orderBy('date', 'desc')
            ->paginate(10);

        $totalOrganizations = Organization::whereHas('user', function($query) {
            $query->where('verified', true);
        })->count();

        return view('home', compact('totalHours', 'totalVolunteers', 'totalOrganizations', 'totalCompletedActivities', 'activities'));
    }
    public function test(): View
    {
        return view('test');
    }
}
