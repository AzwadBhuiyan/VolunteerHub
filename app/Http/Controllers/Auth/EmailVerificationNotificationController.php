<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // If user is not authenticated but has email in session
        if (!$request->user() && session()->has('email_for_verification')) {
            $user = User::where('email', session('email_for_verification'))->first();
            if ($user) {
                Auth::login($user);
            }
        }
    
        if (!$request->user()) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Please log in to verify your email.']);
        }
    
        // Check both verification methods
        if ($request->user()->verified && $request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('home', absolute: false));
        }
    
        // Check cooldown period
        $lastVerificationRequest = $request->session()->get('last_verification_request');
        $cooldownPeriod = now()->subMinutes(3);
    
        if ($lastVerificationRequest && Carbon::parse($lastVerificationRequest)->isAfter($cooldownPeriod)) {
            return back()->withErrors(['email' => 'Please wait 3 minutes before requesting another verification link.']);
        }
    
        // Store the timestamp of this request
        $request->session()->put('last_verification_request', now());
    
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('status', 'verification-link-sent');
    }
}