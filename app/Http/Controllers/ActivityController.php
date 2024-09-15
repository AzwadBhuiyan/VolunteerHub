<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function create()
    {
        return view('activities.create');
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
            'image' => 'nullable|image|max:2048', // 2MB Max
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
            'image' => 'nullable|image|max:2048', // 2MB Max
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
}