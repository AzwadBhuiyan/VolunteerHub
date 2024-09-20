<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Volunteer;

class ActivityController extends Controller
{
    public function create()
    {
        return view('activities.create');
    }

    public function feed()
    {
        $activities = Activity::where('status', 'open')
                            ->with('organization')
                            ->orderBy('date', 'asc')
                            ->paginate(10);

        return view('activities.feed', compact('activities'));
    }

    public function show(Activity $activity)
    {
        // Authorization check can be added here
        return view('activities.show', compact('activity'));
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->organization) {
            $activities = $user->organization->activities()->latest()->paginate(10);
            
            // Debug: Check if we're getting any activities
            \Log::info('Activities count: ' . $activities->count());
            \Log::info('First activity: ' . json_encode($activities->first()));
            
            return view('activities.index', compact('activities'));
        } else {
            return redirect()->route('home')->with('error', 'Only organizations can view activities.');
        }
    }

    // create new activity
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'category' => 'required',
            'district' => 'required',
            'address' => 'required',
            'deadline' => 'required|date',
            'min_volunteers' => 'required|integer|min:1',
            'max_volunteers' => 'nullable|integer|gt:min_volunteers',
            'image' => 'nullable|image|max:5120', // 5MB Max
        ]);

        $validatedData['userid'] = Auth::id();
        $validatedData['status'] = 'open';

        $activity = Activity::create($validatedData);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = $activity->activityid . '.' . $extension;
            
            $path = public_path('images/activities/' . $activity->activityid);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $image->move($path, $filename);
        }

        return redirect()->route('activities.create')->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity)
    {
        // $this->authorize('update', $activity);
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {


        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'category' => 'required',
            'district' => 'required',
            'address' => 'required',
            'deadline' => 'required|date',
            'min_volunteers' => 'required|integer|min:1',
            'max_volunteers' => 'nullable|integer|gt:min_volunteers',
            'image' => 'nullable|image|max:5120', // 5MB Max
        ]);

        $activity->update($validatedData);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = $activity->activityid . '.' . $extension;
            
            $path = public_path('images/activities/' . $activity->activityid);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $image->move($path, $filename);
        }

        return redirect()->route('activities.show', $activity)->with('success', 'Activity updated successfully.');
    }

    public function updateStatus(Request $request, Activity $activity)
    {
        // $this->authorize('update', $activity);

        $validatedData = $request->validate([
            'status' => 'required|in:' . implode(',', Activity::STATUSES),
        ]);

        $activity->update($validatedData);

        return redirect()->route('activities.index')->with('success', 'Activity status updated successfully.');
    }

    public function showSignups(Request $request, Activity $activity)
    {
        if (Auth::id() != $activity->userid) {
            return redirect()->route('activities.show', $activity)->with('error', 'Unauthorized access.');
        }

        $query = $activity->volunteers()
            ->withPivot('approval_status')
            ->with('user');

        // Search by name
        if ($request->has('search')) {
            $query->where('Name', 'like', '%' . $request->search . '%');
        }

        // Filter by points range
        if ($request->has('min_points') && $request->has('max_points')) {
            $query->whereBetween('Points', [$request->min_points, $request->max_points]);
        }

        $volunteers = $query->get();

        return view('activities.show_signups', compact('activity', 'volunteers'));
    }

    
    // public function updateVolunteerStatus(Request $request, Activity $activity, Volunteer $volunteer)
    // {
    //     if (Auth::id() != $activity->userid) {
    //         return redirect()->route('activities.show', $activity)->with('error', 'Unauthorized access.');
    //     }

    //     $validatedData = $request->validate([
    //         'approval_status' => 'required|in:pending,approved,rejected',
    //     ]);

    //     $activity->volunteers()->updateExistingPivot($volunteer->userid, [
    //         'approval_status' => $validatedData['approval_status']
    //     ]);

    //     return redirect()->route('activities.show_signups', $activity)->with('success', 'Volunteer status updated successfully.');
    // }

    public function updateMultipleVolunteerStatus(Request $request, Activity $activity)
    {
        if (Auth::id() != $activity->userid) {
            return redirect()->route('activities.show', $activity)->with('error', 'Unauthorized access.');
        }

        $validatedData = $request->validate([
            'selected_volunteers' => 'required|array',
            'selected_volunteers.*' => 'exists:volunteers,userid',
            'approval_status' => 'required|in:pending,approved,rejected',
        ]);

        // If trying to approve volunteers
        if ($validatedData['approval_status'] === 'approved') {
            $currentApprovedCount = $activity->confirmedVolunteers()->count();
            $newApprovedCount = count($validatedData['selected_volunteers']);
            $totalApprovedCount = $currentApprovedCount + $newApprovedCount;

            // Check if approving these volunteers would exceed the max_volunteers limit
            if ($activity->max_volunteers && $totalApprovedCount > $activity->max_volunteers) {
                return redirect()->route('activities.show_signups', $activity)
                    ->with('error', "Cannot approve {$newApprovedCount} volunteers. It would exceed the maximum limit of {$activity->max_volunteers} volunteers.");
            }
        }

        foreach ($validatedData['selected_volunteers'] as $volunteerUserId) {
            $activity->volunteers()->updateExistingPivot($volunteerUserId, [
                'approval_status' => $validatedData['approval_status']
            ]);
        }

        return redirect()->route('activities.show_signups', $activity)
            ->with('success', 'Volunteer statuses updated successfully.');
    }
    //volunteer registers for an activity
    public function register(Activity $activity)
    {
        $user = Auth::user();
        if (!$user->volunteer) {
            return redirect()->route('activities.feed')->with('error', 'Only volunteers can register for activities.');
        }

        if ($activity->status !== 'open') {
            return redirect()->route('activities.feed')->with('error', 'This activity is no longer open for registration.');
        }

        // Check if the volunteer is already registered
        if ($activity->volunteers()->where('volunteer_userid', $user->volunteer->userid)->exists()) {
            return redirect()->route('activities.feed')->with('error', 'You are already registered for this activity.');
        }

        // Register the volunteer
        $activity->volunteers()->attach($user->volunteer->userid, ['approval_status' => 'pending']);

        return redirect()->route('activities.feed')->with('success', 'You have successfully registered for this activity.');
    }
}