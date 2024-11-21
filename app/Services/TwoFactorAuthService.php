<?php

namespace App\Services;

use App\Notifications\TwoFactorCode;
use Illuminate\Support\Facades\Log;

class TwoFactorAuthService
{
    public function generateAndSendCode($user)
    {
        try {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            $user->update([
                'two_factor_code' => $code,
                'two_factor_expires_at' => now()->addMinutes(10)
            ]);

            $user->notify(new TwoFactorCode($code));
            Log::info('2FA code sent to user: ' . $user->email);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send 2FA code: ' . $e->getMessage());
            return false;
        }
    }
}