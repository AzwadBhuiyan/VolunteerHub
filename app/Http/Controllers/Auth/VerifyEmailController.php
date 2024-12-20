<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find($request->route('userid'));

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid verification link.']);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('status', 'Email already verified. Please login.');
        }

        // Verify that the hash matches
        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid verification link.']);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));
        
        // Update the legacy verified column too
        $user->update(['verified' => true]);

        // Log the user in
        Auth::login($request->user());

        // Auto login the user
        return $this->redirectToPublicProfile($request->user())
            ->with('status', 'Your email has been verified. Please complete your profile to get started.');
    }

    private function redirectToPublicProfile($user): RedirectResponse
    {
        $profile = $user->volunteer ?? $user->organization;
        return redirect()->route('profile.public', ['url' => $profile->url]);
    }
}