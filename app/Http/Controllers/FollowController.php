<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class FollowController extends Controller
{
    public function follow(Request $request, Organization $organization)
    {
        $request->user()->volunteer->followedOrganizations()->attach($organization);
        return back()->with('status', 'Organization followed successfully.');
    }

    public function unfollow(Request $request, Organization $organization)
    {
        $request->user()->volunteer->followedOrganizations()->detach($organization);
        return back()->with('status', 'Organization unfollowed successfully.');
    }
}