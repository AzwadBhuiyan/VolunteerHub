<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Volunteer;
use App\Models\Organization;
use App\Models\Activity;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show($userid)
    {
        $user = User::findOrFail($userid);
        
        if ($user->volunteer) {
            $profile = $user->volunteer;
            $profile->userid = $user->userid; // Ensure userid is set
            $completedActivities = Activity::whereHas('volunteers', function ($query) use ($userid) {
                $query->where('volunteer_userid', $userid)->where('approval_status', 'approved');
            })->where('status', 'completed')->get();
            
            return view('profile.public-profile-volunteer', compact('profile', 'completedActivities'));
        } elseif ($user->organization) {
            $profile = $user->organization;
            $profile->userid = $user->userid; // Ensure userid is set
            $completedActivities = $user->activities()->where('status', 'completed')->get();
            $ongoingActivities = $user->activities()->where('status', 'open')->get();
            
            return view('profile.public-profile-organization', compact('profile', 'completedActivities', 'ongoingActivities'));
        }
        
        abort(404);
    }
}