<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Volunteer;
use App\Models\ActivityRequest;

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
        } else if ($user->volunteer){
            $recentActivities = $user->volunteer->activities()
            ->orderBy('date', 'desc')
            ->get();
                
            return view('dashboard', compact('recentActivities'));
        } else if ($user->admin){
            return view('admin');
        }
    }
}
