<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityMilestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityMilestoneController extends Controller
{
    public function store(Request $request, Activity $activity)
    {
        if (Auth::id() !== $activity->userid || $activity->status === 'completed') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'message' => 'required|string'
        ]);

        $milestone = $activity->milestones()->create($validatedData);

        // Create read records for all approved volunteers
        $approvedVolunteers = $activity->volunteers()
            ->wherePivot('approval_status', 'approved')
            ->get();

        foreach ($approvedVolunteers as $volunteer) {
            $milestone->reads()->create([
                'volunteer_userid' => $volunteer->userid,
                'is_read' => false
            ]);
        }

        return redirect()->route('activities.timeline', $activity)
            ->with('success', 'Milestone added successfully');
    }

    public function markAsRead(ActivityMilestone $milestone)
    {
        $volunteer = Auth::user()->volunteer;
        
        if (!$volunteer) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $read = $milestone->reads()
            ->where('volunteer_userid', $volunteer->userid)
            ->first();

        if ($read) {
            $read->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }

        return response()->json(['success' => true]);
    }
}