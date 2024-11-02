<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Volunteer;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->organization) {
            $activities = $user->organization->activities()
                ->orderBy('date', 'desc')
                ->get();
                
            return view('dashboard', compact('activities'));
        } else {
            $recentActivities = $user->volunteer->activities()
            ->wherePivot('approval_status', 'approved')
            ->orderBy('date', 'desc')
            ->get();
                
            return view('dashboard', compact('recentActivities'));
        }
    }
}
