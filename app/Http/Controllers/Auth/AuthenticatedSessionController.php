<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = $request->user();

        if (!$user->verified) {
            Auth::logout();
            return redirect()->route('login')
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'You need to verify your email address before logging in.']);
        }

        $request->session()->regenerate();

        // Explicitly set the user ID in the session
        $request->session()->put('auth.id', Auth::id());

        // Store user type in session
        $user = Auth::user();
        $userType = $user->volunteer ? 'volunteer' : 'organization';
        session(['user_type' => $userType]);

        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}