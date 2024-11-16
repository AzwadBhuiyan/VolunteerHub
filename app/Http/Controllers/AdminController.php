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

class AdminController extends Controller
{
    private function checkAdminAccess()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }

    public function users()
    {
        $this->checkAdminAccess();
        $users = User::with(['volunteer', 'organization'])->paginate(10);
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

        return view('admin.dashboard', compact('totalUsers', 'activeVolunteers', 'activeOrganizations', 'totalIdeaThreads'));
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

    public function activities()
    {
        $this->checkAdminAccess();
        
        $activities = Activity::with(['organization', 'volunteers'])
            ->orderBy('date', 'desc')
            ->paginate(10);
        
        return view('admin.activities.index', compact('activities'));
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

    public function ideaThreads()
    {
        $this->checkAdminAccess();
        
        $ideaThreads = IdeaThread::with(['organization', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.idea_threads.index', compact('ideaThreads'));
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

    public function volunteers()
    {
        $this->checkAdminAccess();
        
        $volunteers = Volunteer::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.volunteers.index', compact('volunteers'));
    }

    public function organizations()
    {
        $this->checkAdminAccess();
        
        $organizations = Organization::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
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
    
}