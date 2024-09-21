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

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = $user->volunteer ?? $user->organization;
        $activities = $user->activities()->latest()->take(5)->get();
        
        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
            'activities' => $activities,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->volunteer ?? $user->organization;

        $user->fill($request->validated());
        $profile->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('profile_picture') && $user->volunteer) {
            $file = $request->file('profile_picture');
            $filename = $user->userid . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile_pictures'), $filename);
        }

        if ($request->hasFile('logo') && $user->organization) {
            $file = $request->file('logo');
            $filename = $user->userid . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/logos'), $filename);
        }

        if ($request->hasFile('cover_image') && $user->organization) {
            $file = $request->file('cover_image');
            $filename = $user->userid . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/cover'), $filename);

        }

        // Handle new fields for volunteer
        if ($user->volunteer) {
            $profile->bio = $request->bio;
            $profile->Phone = $request->phone;
            $profile->BloodGroup = $request->blood_group;
        }

        // Handle new fields for organization
        if ($user->organization) {
            $profile->description = $request->description;
            $profile->website = $request->website;
            $profile->primary_address = $request->primary_address;
            $profile->secondary_address = $request->secondary_address;
            $profile->org_mobile = $request->org_mobile;
            $profile->org_telephone = $request->org_telephone;
        }

        // // Update userid if provided
        // if ($newUserid && $newUserid !== $user->userid) {
        //     $request->validate([
        //         'new_userid' => ['required', 'string', 'max:255', 'unique:users,userid,' . $user->userid . ',userid'],
        //     ]);
        //     $user->userid = $newUserid;
        // }



        $user->save();
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

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = $user->userid . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/logos'), $filename);
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = $user->userid . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/cover'), $filename);
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
            'org_mobile' => ['required', 'string', 'max:11'],
            'org_telephone' => ['nullable', 'string', 'between:7,11'],
        ]);

        $profile->update($request->only(['primary_address', 'secondary_address', 'org_mobile', 'org_telephone']));

        return Redirect::route('profile.edit')->with('status', 'organization-additional-updated');
    }

    public function updateVolunteerAdditional(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->volunteer;

        $validated = $request->validate([
            'nid' => 'nullable|string|max:255',
            'present_address' => 'required|string|max:300',
            'permanent_address' => 'required|string|max:300',
            'district' => 'required|string',
            'trained_in_emergency' => 'boolean',
        ]);

        $profile->NID = $validated['nid'];
        $profile->PresentAddress = $validated['present_address'];
        $profile->PermanentAddress = $validated['permanent_address'];
        $profile->District = $validated['district'];
        $profile->TrainedInEmergencyResponse = $validated['trained_in_emergency'] ?? false;

        $profile->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}