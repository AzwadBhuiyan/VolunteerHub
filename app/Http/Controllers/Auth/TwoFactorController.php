<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use App\Services\TwoFactorAuthService;


class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.two-factor-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = auth()->user();

        if ($request->code !== $user->two_factor_code || 
            $user->two_factor_expires_at->isPast()) {
            return back()->withErrors(['code' => 'The provided code is invalid or expired.']);
        }

        session(['two_factor_verified' => true]);
        $user->two_factor_code = null;
        $user->save();

        session()->forget('auth.login');

        return redirect()->intended('dashboard');
    }

    public function resend()
    {
        $user = auth()->user();
        
        if ($user->two_factor_expires_at && 
            $user->two_factor_expires_at->diffInSeconds(now()) < 60) {
            return response()->json(['message' => 'Please wait before requesting another code.'], 429);
        }
    
        if (app(TwoFactorAuthService::class)->generateAndSendCode($user)) {
            return response()->json(['message' => 'Code resent successfully.']);
        }
    
        return response()->json(['message' => 'Failed to send code'], 500);
    }
}