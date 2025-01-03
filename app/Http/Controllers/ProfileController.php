<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Volunteer;
use App\Models\Organization;
use App\Models\User;
use App\Models\TutorialProgress;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = $user->volunteer ?? $user->organization;
        $activities = $user->activities()->latest()->take(5)->get();

        $securityData = $this->getSecurityData();
        
        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
            'activities' => $activities,
            'anyTutorialDisabled' => $securityData['anyTutorialDisabled'],
        ]);
    }

    // THIS ONLY UPDATES VOLUNTEER
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->volunteer ?? $user->organization;

        $user->fill($request->validated());
        $profile->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->verified = false;
            $user->sendEmailVerificationNotification();
        }

        if ($request->hasFile('profile_picture') && $user->volunteer) {
            $file = $request->file('profile_picture');
            $filename = $user->userid . '.' . $file->getClientOriginalExtension();
            $path = public_path('images/profile_pictures');
            
            // Delete existing profile picture
            $existingFiles = glob($path . '/' . $user->userid . '.*');
            foreach ($existingFiles as $existingFile) {
                unlink($existingFile);
            }
            
            $file->move($path, $filename);
        }

        // Handle new fields for volunteer
        if ($user->volunteer) {
            $profile->bio = $request->bio;
            $profile->Phone = $request->phone;
            $profile->BloodGroup = $request->blood_group;
            $profile->url = $request->url;
        }

        $user->save();
        $profile->save();


        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateOrganization(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->organization;

        $request->validate([
            'logo' => ['nullable', 'image', 'max:5120'],
            'cover_image' => ['nullable', 'image', 'max:5120'],
            'description' => ['required', 'string', 'max:150'],
            'website' => ['nullable', 'string', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'url' => [
                'sometimes',
                'string',
                'max:30',],
        ]);

        if ($request->hasFile('logo') && $user->organization) {
            $file = $request->file('logo');
            $filename = $user->userid . '.' . $file->getClientOriginalExtension();
            $path = public_path('images/logos');
            
            // Delete existing logo
            $existingFiles = glob($path . '/' . $user->userid . '.*');
            foreach ($existingFiles as $existingFile) {
                unlink($existingFile);
            }
            
            $file->move($path, $filename);
        }

        if ($request->hasFile('cover_image') && $user->organization) {

            $file = $request->file('cover_image');
            $filename = $user->userid . '.' . $file->getClientOriginalExtension();
            $path = public_path('images/cover');
            
            // Delete existing cover image
            $existingFiles = glob($path . '/' . $user->userid . '.*');
            foreach ($existingFiles as $existingFile) {
                unlink($existingFile);
            }
            
            $file->move($path, $filename);
        }

        if ($request->has('url')) {
            $newUrl = $request->url;
            if ($user->organization) {
                $newUrl = 'org-' . ltrim($newUrl, 'org-');
            }
            
            // Check if the new URL is unique
            if (($user->volunteer && Volunteer::where('url', $newUrl)->where('userid', '!=', $user->userid)->exists()) ||
                ($user->organization && Organization::where('url', $newUrl)->where('userid', '!=', $user->userid)->exists())) {
                return Redirect::back()->withErrors(['url' => 'This URL is already taken.']);
            }
            
            $profile->url = $newUrl;
        }

        $profile->update($request->only(['description', 'website', 'url']));

        return Redirect::route('profile.edit')->with('status', 'organization-updated');
    }

    public function updateOrganizationAdditional(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->organization;

        $request->validate([
            'primary_address' => ['required', 'string', 'max:300'],
            'secondary_address' => ['nullable', 'string', 'max:300'],
            'org_mobile' => ['required', 'string', 'size:11'],
            'org_telephone' => ['nullable', 'string', 'between:7,11'],
            'contact_email' => ['nullable', 'email', 'max:255'],
        ]);

        $profile->update($request->only(['primary_address', 'secondary_address', 'org_mobile', 'org_telephone', 'contact_email']));

        return Redirect::route('profile.edit')->with('status', 'organization-additional-updated');
    }

    public function updateVolunteerAdditional(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->volunteer;

        $validated = $request->validate([
            'nid' => 'nullable|numeric|digits:10',
            'present_address' => 'required|string|max:300',
            'permanent_address' => 'nullable|string|max:300',
            'district' => 'required|string',
            'trained_in_emergency' => 'boolean',
            'profession' => 'nullable|string|max:100',
        ]);

        $profile->NID = $validated['nid'];
        $profile->PresentAddress = $validated['present_address'];
        $profile->PermanentAddress = $validated['permanent_address'];
        $profile->District = $validated['district'];
        $profile->TrainedInEmergencyResponse = $validated['trained_in_emergency'] ?? false;
        $profile->Profession = !empty($validated['profession']) ? $validated['profession'] : null;

        $profile->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateSecurity(Request $request)
    {
        $validated = $request->validate([
            'max_attempts' => ['required', 'integer', 'min:3', 'max:10'],
            'allow_follow' => ['sometimes', 'boolean'],
            'two_factor_enabled' => ['required', 'boolean'],
            'show_posts' => ['required', 'boolean'],
            'show_tutorials' => ['required', 'boolean'],
        ]);
    
        $user = $request->user();
        
        if ($validated['two_factor_enabled'] && !$user->hasVerifiedEmail()) {
            return back()->withErrors(['two_factor_enabled' => 'Please verify your email address before enabling 2FA.']);
        }
        
        $user->max_attempts = $validated['max_attempts'];
        $user->two_factor_enabled = $validated['two_factor_enabled'];
        $user->show_posts = $validated['show_posts'];
        
        if ($user->volunteer) {
            $user->volunteer->allow_follow = $validated['allow_follow'] ?? false;
            $user->volunteer->save();
        }
        
        // Update tutorial settings
        TutorialProgress::where('userid', $user->userid)
            ->update(['dont_show_again' => !$validated['show_tutorials']]);
        
        $user->save();
    
        return back()->with('status', 'security-updated');
    }

    private function getSecurityData()
    {
        $anyTutorialDisabled = TutorialProgress::where('userid', auth()->user()->userid)
            ->where('dont_show_again', true)
            ->exists();

        return [
            'anyTutorialDisabled' => $anyTutorialDisabled
        ];
    }

    public function showOrganizationAbout(Organization $organization): View
    {
        $ongoingActivities = $organization->activities()
            ->where('status', '!=', 'completed')
            ->latest()
            ->take(3)
            ->get();
            
        $completedActivities = $organization->activities()
            ->where('status', 'completed')
            ->latest()
            ->take(3)
            ->get();

        return view('profile.about', [
            'organization' => $organization,
            'ongoingActivities' => $ongoingActivities,
            'completedActivities' => $completedActivities
        ]);
    }

    public function showOrganizationContact(Organization $organization): View
    {
        return view('profile.contact', [
            'organization' => $organization
        ]);
    }

    public function sendOrganizationMessage(Request $request, Organization $organization): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        // Here you would typically handle the message sending logic
        // For example, sending an email or storing in the database

        return back()->with('status', 'Message sent successfully!');
    }

}
