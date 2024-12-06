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
use App\Notifications\TwoFactorCode;
use App\Services\TwoFactorAuthService;

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

        if (!$user){
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'This account does not exist']);
        }

        if (!$user->email_verified_at) {
            Auth::logout();
            return redirect()->route('login')
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'You need to verify your email address before logging in.']);
        }
        if (!$user->verified) {
            Auth::logout();
            return redirect()->route('login')
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Your account is suspended. Contact the administrator.']);
        }

        $request->session()->regenerate();

        // Set login session flag for 2FA
        if ($user->two_factor_enabled) {
            if (app(TwoFactorAuthService::class)->generateAndSendCode($user)) {
                session(['auth.login' => true]);
                session()->forget('two_factor_verified');
                return redirect()->route('2fa.verify');
            }
            
            auth()->logout();
            return back()->withErrors(['email' => 'Failed to send verification code']);
        }

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