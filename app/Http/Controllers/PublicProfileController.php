<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Volunteer;
use App\Models\Organization;
use App\Models\Activity;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show($url)
    {
        $profile = Volunteer::where('url', $url)->first() ?? Organization::where('url', $url)->first();
        
        if (!$profile) {
            abort(404);
        }
        
        $user = $profile->user;
        
        if ($user->volunteer) {
            $completedActivities = Activity::whereHas('volunteers', function ($query) use ($user) {
                $query->where('volunteer_userid', $user->userid)->where('approval_status', 'approved');
            })->where('status', 'completed')->get();
            
            return view('profile.public-profile-volunteer', compact('profile', 'completedActivities'));
        } elseif ($user->organization) {
            $completedActivities = $user->activities()->where('status', 'completed')->get();
            $ongoingActivities = $user->activities()->where('status', 'open')->get();
            
            return view('profile.public-profile-organization', compact('profile', 'completedActivities', 'ongoingActivities'));
        }
        
        abort(404);
    }
}