<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
            'logo' => ['nullable', 'image', 'max:1024'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'description' => ['required', 'string', 'max:1000'],
            'website' => ['required', 'url', 'max:255'],
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

        $profile->update($request->only(['description', 'website']));

        return Redirect::route('profile.edit')->with('status', 'organization-updated');
    }

    public function updateOrganizationAdditional(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->organization;

        $request->validate([
            'primary_address' => ['required', 'string', 'max:255'],
            'secondary_address' => ['nullable', 'string', 'max:255'],
            'org_mobile' => ['required', 'string', 'max:20'],
            'org_telephone' => ['nullable', 'string', 'max:20'],
        ]);

        $profile->update($request->only(['primary_address', 'secondary_address', 'org_mobile', 'org_telephone']));

        return Redirect::route('profile.edit')->with('status', 'organization-additional-updated');
    }
}