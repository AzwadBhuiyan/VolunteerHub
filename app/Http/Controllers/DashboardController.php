<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $activities = null;
        
        if (Auth::user()->organization) {
            $activities = Auth::user()->organization->activities()
                ->orderBy('date', 'desc')
                ->get();  // Changed from paginate() to get()
        }
        
        return view('dashboard', compact('activities'));
    }
}
