<?php

namespace App\Http\Controllers;

use App\Models\ActivityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityRequestController extends Controller
{
    public function index()
    {
        if (!Auth::user()->organization) {
            return redirect()->route('dashboard')->with('error', 'Only organizations can view activity requests.');
        }

        $requests = ActivityRequest::with('volunteer')
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->paginate(10);

        Auth::user()->organization->markRequestsAsRead();

        return view('activity-requests.index', compact('requests'));
    }

    public function create()
    {
        $volunteer = Auth::user()->volunteer;
        
        if (!$volunteer) {
            return redirect()->route('dashboard')->with('error', 'Only volunteers can create activity requests.');
        }

        if (!$volunteer->canMakeRequest()) {
            return redirect()->route('dashboard')->with('error', 'You have reached your monthly request limit.');
        }

        return view('activity-requests.create');
    }

    public function store(Request $request)
    {
        $volunteer = Auth::user()->volunteer;
        
        if (!$volunteer->canMakeRequest()) {
            return redirect()->route('dashboard')->with('error', 'You have reached your monthly request limit.');
        }

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'district' => 'required|in:' . implode(',', config('districts.districts')),
            'image' => 'required|image|max:5120', // 5MB Max
        ]);

        $validatedData['volunteer_userid'] = $volunteer->userid;
        
        $activityRequest = ActivityRequest::create($validatedData);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = $activityRequest->id . '.' . $extension;
            
            $path = public_path('images/requests');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $image->move($path, $filename);
        }

        return redirect()->route('dashboard')->with('success', 'Activity request submitted successfully.');
    }

    public function approve(ActivityRequest $request)
    {
        if (!Auth::user()->organization) {
            return redirect()->route('dashboard')->with('error', 'Only organizations can approve requests.');
        }

        if ($request->status == 'approved' || $request->activity_id) {
            return back()->with('error', 'This request has already been processed or is being processed by another organization.');
        }

        $request->update([
            'status' => 'in_progress',
        ]);

        return redirect()->route('activities.create', ['request_id' => $request->id])
            ->with('success', 'Create the activity now.');
    }

    public function reject(ActivityRequest $request)
    {
        if (!Auth::user()->organization) {
            return redirect()->route('dashboard')->with('error', 'Only organizations can reject requests.');
        }

        if ($request->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $request->update(['status' => 'rejected']);

        return back()->with('success', 'Request rejected successfully.');
    }

    public function show(ActivityRequest $request)
    {
        if (!Auth::user()->organization) {
            return redirect()->route('dashboard')->with('error', 'Only organizations can view activity requests.');
        }

        return view('activity-requests.show', compact('request'));
    }
}