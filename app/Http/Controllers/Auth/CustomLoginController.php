<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TwoFactorCode;
use App\Services\TwoFactorAuthService;
use App\Models\User;

class CustomLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && !$user->verified) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Your account is not verified. Please check your email for verification instructions.']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->two_factor_enabled) {
                if (app(TwoFactorAuthService::class)->generateAndSendCode($user)) {
                    session(['auth.login' => true]);
                    session()->forget('two_factor_verified');
                    return redirect()->route('2fa.verify');
                }
                
                auth()->logout();
                return back()->withErrors(['email' => 'Failed to send verification code']);
            }
            
            return redirect()->route('dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }
}