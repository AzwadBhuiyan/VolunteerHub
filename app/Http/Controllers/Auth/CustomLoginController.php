<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('userid', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user->verified) {
                return redirect()->route('verification.notice');
            }
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'userid' => 'The provided credentials do not match our records.',
        ]);
    }
}