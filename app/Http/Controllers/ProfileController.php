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
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $path;
        }

        if ($request->hasFile('logo') && $user->organization) {
            $path = $request->file('logo')->store('organization_logos', 'public');
            $profile->logo = $path;
        }

        if ($request->hasFile('cover_image') && $user->organization) {
            $path = $request->file('cover_image')->store('organization_covers', 'public');
            $profile->cover_image = $path;
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
}