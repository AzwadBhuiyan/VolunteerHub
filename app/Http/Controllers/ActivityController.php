<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Volunteer;
use App\Models\ActivityCategory;

class ActivityController extends Controller
{
    public function create()
    {
        $categories = ActivityCategory::all();
        return view('activities.create', compact('categories'));
    }
    

    public function feed()
    {
        $activities = Activity::with('organization')
            ->orderBy('date', 'desc')
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
            'category' => 'required|exists:activity_categories,name',
            'district' => 'required',
            'difficulty' => 'required|in:easy,medium,hard,severe',
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

        return redirect()->route('dashboard')->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity)
    {
        // $this->authorize('update', $activity);
        $categories = ActivityCategory::all();
        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(Request $request, Activity $activity)
    {


        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'category' => 'required|exists:activity_categories,name',
            'district' => 'required',
            'difficulty' => 'required|in:easy,medium,hard,severe',
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

        if ($request->filled('status')) {
            $query->wherePivot('approval_status', $request->status);
        }

        if ($request->filled('level')) {
            $levelPoints = Volunteer::getLevelPoints($request->level);
            $query->where(function ($q) use ($levelPoints) {
                $q->where('Points', '>=', $levelPoints['min'])
                  ->where('Points', '<', $levelPoints['max']);
            });
        }

        if ($request->filled('min_age') || $request->filled('max_age')) {
            $query->where(function ($q) use ($request) {
                $minDate = now()->subYears($request->input('max_age', 100))->toDateString();
                $maxDate = now()->subYears($request->input('min_age', 0))->toDateString();
                $q->whereBetween('DOB', [$minDate, $maxDate]);
            });
        }

        if ($request->filled('gender')) {
            $query->where('Gender', $request->gender);
        }

        $volunteers = $query->get();

        return view('activities.show_signups', compact('activity', 'volunteers'));
    }

    public function showAccomplished(Activity $activity)
    {
        if ($activity->status !== 'completed') {
            return redirect()->route('activities.show', $activity)->with('error', 'This activity has not been completed yet.');
        }

        $accomplishedPath = 'images/activities/' . $activity->activityid . '/accomplished/';
        $accomplishedFullPath = public_path($accomplishedPath);
        $accomplishedPhotos = File::exists($accomplishedFullPath) ? File::files($accomplishedFullPath) : [];

        return view('activities.show_accomplished', compact('activity', 'accomplishedPhotos'));
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

    // ````````````````````````````````````
    //volunteer registers for an activity
    // ````````````````````````````````````
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

        return redirect()->route('activities.feed')->with('success', 'You have registered for this activity. Wait for approval from the organization.');
    }

// ````````````````````````````````````
    // Completing an activity by an organization
// ````````````````````````````````````
    public function complete(Activity $activity)
    {
        // Authorization check can be added here
        return view('activities.complete', compact('activity'));
    }

    public function completeStore(Request $request, Activity $activity)
    {
        $validatedData = $request->validate([
            'accomplished_description' => 'required',
            'duration' => 'required|numeric|min:1.0', // Changed to numeric and min 0.5 hours
            'photos' => 'required|array|min:1|max:4',
            'photos.*' => 'image|max:5120', // 5MB Max
        ]);

        // Round up the duration to the nearest integer
        $roundedDuration = ceil($validatedData['duration']);

        // Calculate points
        $difficultyPoints = [
            'easy' => 1,
            'medium' => 2,
            'hard' => 3,
            'severe' => 5
        ];

        $points = $roundedDuration * ($difficultyPoints[$activity->difficulty] ?? 1);

        $activity->update([
            'accomplished_description' => $validatedData['accomplished_description'],
            'duration' => $roundedDuration, // Use the rounded value
            'status' => 'completed',
            'points' => $points
        ]);

        // Update points for registered volunteers
        $registeredVolunteers = $activity->volunteers()->wherePivot('approval_status', 'approved')->get();
        foreach ($registeredVolunteers as $volunteer) {
            $volunteer->increment('Points', $points);
        }


        if ($request->hasFile('photos')) {
            $path = public_path('images/activities/' . $activity->activityid . '/accomplished');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            foreach ($request->file('photos') as $index => $photo) {
                $filename = ($index + 1) . '.' . $photo->getClientOriginalExtension();
                $photo->move($path, $filename);
            }
        }

        return redirect()->route('activities.index')->with('success', 'Activity completed successfully.');
    }

    public function cancelRegistration(Activity $activity)
    {
        $user = Auth::user();
        if ($user->volunteer) {
            $activity->volunteers()->detach($user->volunteer->userid);
            return redirect()->route('activities.feed')->with('success', 'Your registration has been cancelled.');
        }
        return redirect()->route('activities.feed')->with('error', 'Unable to cancel registration.');
    }

}