<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Organization;
use App\Models\Activity;
use App\Models\IdeaThread;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class AdminController extends Controller
{
    private function checkAdminAccess()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }

    public function users(Request $request)
    {
        $this->checkAdminAccess();
        
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('userid', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('verified', $status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function dashboard()
    {
        $this->checkAdminAccess();
        
        $totalUsers = User::count();
        $activeVolunteers = User::where('role', 'volunteer')
            ->where('verified', true)
            ->count();
        $activeOrganizations = User::where('role', 'organization')
            ->where('verified', true)
            ->count();
        $totalIdeaThreads = IdeaThread::count();

        // Get current year
        $currentYear = now()->year;
        
        // Volunteer growth data
        $volunteerData = User::where('role', 'volunteer')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Organization growth data
        $organizationData = User::where('role', 'organization')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Activities data
        $activityData = [
            'created' => Activity::whereYear('created_at', $currentYear)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray(),
            'completed' => Activity::whereYear('date', $currentYear)
                ->where('status', 'completed')
                ->selectRaw('MONTH(date) as month, COUNT(*) as count')
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray()
        ];

        // Fill in missing months with zeros
        $months = range(1, 12);
        foreach ($months as $month) {
            $volunteerData[$month] = $volunteerData[$month] ?? 0;
            $organizationData[$month] = $organizationData[$month] ?? 0;
            $activityData['created'][$month] = $activityData['created'][$month] ?? 0;
            $activityData['completed'][$month] = $activityData['completed'][$month] ?? 0;
        }
        ksort($volunteerData);
        ksort($organizationData);
        ksort($activityData['created']);
        ksort($activityData['completed']);

        return view('admin.dashboard', compact(
            'totalUsers', 
            'activeVolunteers', 
            'activeOrganizations', 
            'totalIdeaThreads',
            'volunteerData',
            'organizationData',
            'activityData'
        ));
    }

    public function toggleUserStatus(Request $request, User $user)
    {
        $this->checkAdminAccess();
        try {
            DB::beginTransaction();
            
            $oldStatus = $user->verified;
            $user->verified = !$user->verified;
            $user->save();

            // Log the action
            Log::info('Admin Action: User status changed', [
                'admin_id' => auth()->id(),
                'target_user' => $user->userid,
                'old_status' => $oldStatus,
                'new_status' => $user->verified,
                'timestamp' => now()
            ]);

            DB::commit();
            return back()->with('success', 'User status updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Action Failed: User status change', [
                'admin_id' => auth()->id(),
                'target_user' => $user->userid,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to update user status');
        }
    }

    public function deleteUser(User $user)
    {
        $this->checkAdminAccess();
        try {
            DB::beginTransaction();

            // Log before deletion
            Log::info('Admin Action: User deletion', [
                'admin_id' => auth()->id(),
                'deleted_user' => $user->toArray(),
                'timestamp' => now()
            ]);

            if ($user->volunteer) {
                $user->volunteer->delete();
            }
            if ($user->organization) {
                $user->organization->delete();
            }
            $user->delete();

            DB::commit();
            return back()->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Action Failed: User deletion', [
                'admin_id' => auth()->id(),
                'target_user' => $user->userid,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to delete user');
        }
    }

    public function activities(Request $request)
    {
        $this->checkAdminAccess();
        
        $query = Activity::with('organization', 'volunteers');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Organization
        if ($request->filled('organization')) {
            $query->where('userid', $request->organization);
        }

        $activities = $query->orderBy('date', 'desc')->paginate(10);
        $organizations = Organization::orderBy('org_name')->get();
        
        return view('admin.activities.index', compact('activities', 'organizations'));
    }

    public function deleteActivity(Activity $activity)
    {
        $this->checkAdminAccess();
        try {
            DB::beginTransaction();
            
            // Log the action
            Log::info('Admin Action: Activity deletion', [
                'admin_id' => auth()->id(),
                'activity_id' => $activity->id,
                'activity_title' => $activity->title,
                'timestamp' => now()
            ]);

            $activity->delete();
            
            DB::commit();
            return back()->with('success', 'Activity deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Action Failed: Activity deletion', [
                'admin_id' => auth()->id(),
                'activity_id' => $activity->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to delete activity');
        }
    }

    public function ideaThreads(Request $request)
    {
        $this->checkAdminAccess();
        
        $query = IdeaThread::with(['organization', 'comments']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Organization
        if ($request->filled('organization')) {
            $query->where('organization_userid', $request->organization);
        }

        // Filter by Date
        if ($request->filled('date')) {
            $date = $request->date;
            $query->where(function($q) use ($date) {
                switch($date) {
                    case 'today':
                        $q->whereDate('created_at', today());
                        break;
                    case 'week':
                        $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $q->whereMonth('created_at', now()->month);
                        break;
                }
            });
        }

        $ideaThreads = $query->orderBy('created_at', 'desc')->paginate(10);
        $organizations = Organization::orderBy('org_name')->get();
        
        return view('admin.idea_threads.index', compact('ideaThreads', 'organizations'));
    }

    public function deleteIdeaThread(IdeaThread $ideaThread)
    {
        $this->checkAdminAccess();
        try {
            DB::beginTransaction();
            
            // Log the action
            Log::info('Admin Action: Idea Thread deletion', [
                'admin_id' => auth()->id(),
                'thread_id' => $ideaThread->id,
                'thread_title' => $ideaThread->title,
                'timestamp' => now()
            ]);

            $ideaThread->delete();
            
            DB::commit();
            return back()->with('success', 'Idea Thread deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Action Failed: Idea Thread deletion', [
                'admin_id' => auth()->id(),
                'thread_id' => $ideaThread->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to delete idea thread');
        }
    }

    public function volunteers(Request $request)
    {
        $this->checkAdminAccess();
        
        $query = Volunteer::with('user', 'activities', 'followedOrganizations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Name', 'like', "%{$search}%")
                  ->orWhere('Phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%")
                        ->orWhere('userid', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('district')) {
            $query->where('District', $request->district);
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->whereHas('user', function($q) use ($status) {
                $q->where('verified', $status);
            });
        }

        $volunteers = $query->orderBy('name', 'asc')->paginate(10);
        return view('admin.volunteers.index', compact('volunteers'));
    }

    public function organizations(Request $request)
    {
        $this->checkAdminAccess();
        
        $query = Organization::with('user', 'activities', 'followers');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('org_name', 'like', "%{$search}%")
                  ->orWhere('org_mobile', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%")
                        ->orWhere('userid', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Verification Status
        if ($request->filled('verification')) {
            $query->where('verification_status', $request->verification);
        }

        // Filter by Account Status
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->whereHas('user', function($q) use ($status) {
                $q->where('verified', $status);
            });
        }

        $organizations = $query->orderBy('org_name', 'asc')->paginate(10);
        return view('admin.organizations.index', compact('organizations'));
    }

    public function editVolunteer(Volunteer $volunteer)
    {
        $this->checkAdminAccess();
        return view('admin.volunteers.edit', compact('volunteer'));
    }

    public function editOrganization(Organization $organization)
    {
        $this->checkAdminAccess();
        return view('admin.organizations.edit', compact('organization'));
    }

    public function updateVolunteer(Request $request, Volunteer $volunteer)
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Phone' => 'required|string|max:11',
            'NID' => 'nullable|string|max:20',
            'Gender' => 'required|string|in:Male,Female,Other',
            'DOB' => 'required|date',
            'BloodGroup' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'PresentAddress' => 'required|string|max:300',
            'PermanentAddress' => 'required|string|max:300',
            'District' => 'required|string',
            'TrainedInEmergencyResponse' => 'boolean',
            'bio' => 'nullable|string|max:150',
            'profession' => 'required|string|max:100',
            'url' => [
                'required',
                'string',
                'max:255',
                Rule::unique('volunteers', 'url')->ignore($volunteer->userid, 'userid')
            ],
        ]);

        try {
            DB::beginTransaction();
            
            Log::info('Admin Action: Volunteer update', [
                'admin_id' => auth()->id(),
                'volunteer_id' => $volunteer->userid,
                'timestamp' => now()
            ]);

            $volunteer->update($validated);
            DB::commit();
            return redirect()->route('admin.volunteers.index')->with('success', 'Volunteer updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Action Failed: Volunteer update', [
                'admin_id' => auth()->id(),
                'volunteer_id' => $volunteer->userid,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to update volunteer');
        }
    }

    public function updateOrganization(Request $request, Organization $organization)
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'org_name' => 'required|string|max:255',
            'primary_address' => 'required|string|max:300',
            'secondary_address' => 'nullable|string|max:300',
            'website' => 'nullable|url|max:255',
            'org_mobile' => 'required|string|max:11',
            'org_telephone' => 'nullable|string|between:7,11',
            'description' => 'required|string|max:150',
            'url' => [
                'required',
                'string',
                'max:255',
                Rule::unique('organizations', 'url')->ignore($organization->userid, 'userid')
            ],
        ]);

        try {
            DB::beginTransaction();
            
            Log::info('Admin Action: Organization update', [
                'admin_id' => auth()->id(),
                'organization_id' => $organization->userid,
                'timestamp' => now()
            ]);

            $organization->update($validated);
            DB::commit();
            return redirect()->route('admin.organizations.index')->with('success', 'Organization updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Action Failed: Organization update', [
                'admin_id' => auth()->id(),
                'organization_id' => $organization->userid,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to update organization');
        }
    }

    // verify organization documents
    public function toggleOrganizationVerification(Organization $organization)
    {
        $this->checkAdminAccess();
        
        try {
            DB::beginTransaction();
            
            $newStatus = $organization->verification_status === 'verified' ? 'unverified' : 'verified';
            $organization->verification_status = $newStatus;
            $organization->save();
            
            Log::info('Admin Action: Organization verification status changed', [
                'admin_id' => auth()->id(),
                'organization_id' => $organization->userid,
                'old_status' => $organization->verification_status,
                'new_status' => $newStatus,
                'timestamp' => now()
            ]);
            
            DB::commit();
            return back()->with('success', 'Organization verification status updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Action Failed: Organization verification toggle', [
                'admin_id' => auth()->id(),
                'organization_id' => $organization->userid,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to update organization verification status');
        }
    }

    public function closeExpiredActivities()
    {
        $this->checkAdminAccess();
        
        try {
            DB::beginTransaction();
            
            $count = Activity::where('status', 'open')
                ->whereDate('deadline', '<=', now())
                ->update(['status' => 'closed']);
            
            // Log the action
            Log::info('Admin Action: Bulk close expired activities', [
                'admin_id' => auth()->id(),
                'activities_closed' => $count,
                'timestamp' => now()
            ]);
            
            DB::commit();
            return back()->with('success', "{$count} expired activities have been closed.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Action Failed: Bulk close expired activities', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to close expired activities.');
        }
    }

    public function createUser()
    {
        return view('admin.users.create_user');
    }

    public function storeUser(Request $request)
    {
        $this->checkAdminAccess();

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'user_type' => 'required|in:volunteer,organization',
            'verified' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'userid' => 'U' . time() . rand(1000, 9999),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->user_type,
                'verified' => $request->verified,
            ]);

            // Create volunteer or organization profile
            if ($request->user_type === 'volunteer') {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'phone' => 'required|string|max:20',
                    'gender' => 'required|in:M,F,O',
                    'dob' => 'required|date',
                    'present_address' => 'required|string',
                    'district' => 'required|string',
                ]);

                Volunteer::create([
                    'userid' => $user->userid,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'present_address' => $request->present_address,
                    'district' => $request->district,
                ]);
            } else {
                $request->validate([
                    'org_name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'primary_address' => 'required|string',
                    'secondary_address' => 'required|string',
                    'website' => 'required|url',
                    'org_mobile' => 'required|string|max:20',
                    'org_telephone' => 'required|string|max:20',
                ]);

                Organization::create([
                    'userid' => $user->userid,
                    'org_name' => $request->org_name,
                    'description' => $request->description,
                    'primary_address' => $request->primary_address,
                    'secondary_address' => $request->secondary_address,
                    'website' => $request->website,
                    'org_mobile' => $request->org_mobile,
                    'org_telephone' => $request->org_telephone,
                    'verification_status' => 'pending',
                ]);
            }

            DB::commit();
            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create user. ' . $e->getMessage()]);
        }
    }


    //Send email from Contact Us view
    public function showContactForm()
    {
        return view('contact');
    }

    public function handleContactForm(Request $request)
    {
        $this->checkAdminAccess();

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        try {
            Mail::to('contact@kormonno.com')->send(new ContactFormMail($validated));
            
            Log::info('Contact Form Submission', [
                'from_email' => $validated['email'],
                'subject' => $validated['subject'],
                'timestamp' => now()
            ]);

            return back()->with('status', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            Log::error('Contact Form Submission Failed', [
                'from_email' => $validated['email'],
                'error' => $e->getMessage()
            ]);
            
            return back()->withInput()
                ->with('error', 'Failed to send message. Please try again later.');
        }
    }

}