<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    

    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        \Log::info('Verification attempt', ['user' => $request->user()->userid]);

        if ($request->user()->verified) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        $request->user()->update(['verified' => true]);

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}