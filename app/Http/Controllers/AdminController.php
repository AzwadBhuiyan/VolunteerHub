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
    
}