<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Volunteer;
use App\Models\Activity;

class FollowController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $followedOrganizations = $user->volunteer->followedOrganizations;
        $followedVolunteers = $user->volunteer->followedVolunteers;
    
        $completedOrganizationActivities = Activity::whereIn('userid', $followedOrganizations->pluck('userid'))
            ->where('status', 'completed')
            ->latest()
            ->paginate(5, ['*'], 'org_page');
    
        $completedVolunteerActivities = Activity::whereHas('volunteers', function ($query) use ($followedVolunteers) {
            $query->whereIn('volunteer_userid', $followedVolunteers->pluck('userid'));
        })
        ->where('status', 'completed')
        ->with(['volunteers' => function ($query) use ($followedVolunteers) {
            $query->whereIn('volunteer_userid', $followedVolunteers->pluck('userid'));
        }])
        ->latest()
        ->paginate(5, ['*'], 'vol_page');
    
        return view('profile.following-index', compact(
            'followedOrganizations',
            'followedVolunteers',
            'completedOrganizationActivities',
            'completedVolunteerActivities'
        ));
    }

    public function manageFollowing(Request $request)
    {
        $user = $request->user();
        $followedOrganizations = $user->volunteer->followedOrganizations()->get();
        $followedVolunteers = $user->volunteer->followedVolunteers()->get();
        return view('profile.manage-following', compact('followedOrganizations', 'followedVolunteers'));
    }
    
    // manage org follow
    public function follow(Request $request, Organization $organization)
    {
        $request->user()->volunteer->followedOrganizations()->attach($organization, ['type' => 'organization']);
        return back()->with('status', 'Organization followed successfully.');
    }

    public function unfollow(Request $request, Organization $organization)
    {
        $request->user()->volunteer->followedOrganizations()->detach($organization);
        return back()->with('status', 'Organization unfollowed successfully.');
    }

    // manage vol follow
    public function followVolunteer(Request $request, Volunteer $volunteer)
    {
        if (!$volunteer->allow_follow) {
            return back()->with('error', 'This volunteer is not accepting new followers.');
        }
    
        $request->user()->volunteer->followedVolunteers()->attach($volunteer, ['type' => 'volunteer']);
        return back()->with('status', 'Volunteer followed successfully.');
    }

    public function unfollowVolunteer(Request $request, Volunteer $volunteer)
    {
        $request->user()->volunteer->followedVolunteers()->detach($volunteer);
        return back()->with('status', 'Volunteer unfollowed successfully.');
    }

    public function toggleFollow(Request $request, Volunteer $volunteer)
    {
        if ($request->user()->id !== $volunteer->userid) {
            return back()->with('error', 'You are not authorized to perform this action.');
        }

        $volunteer->allow_follow = !$volunteer->allow_follow;
        $volunteer->save();

        $message = $volunteer->allow_follow ? 'Follow feature turned on.' : 'Follow feature turned off.';
        return back()->with('status', $message);
    }

    

}
