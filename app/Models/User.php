<?php

namespace App\Models;


use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $primaryKey = 'userid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'userid', 'email', 'password', 'verified',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function volunteer()
    {
        return $this->hasOne(Volunteer::class, 'userid');
    }

    public function organization()
    {
        return $this->hasOne(Organization::class, 'userid');
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'userid', 'userid');
    }

    public static function generateUserid($userType)
    {
        $lastUser = self::orderBy('userid', 'desc')->first();
        $lastId = $lastUser ? intval(preg_replace('/[^0-9]/', '', $lastUser->userid)) : 0;
        $newId = $lastId + 1;

        if ($userType === 'organization') {
            return 'org-' . str_pad($newId, 3, '0', STR_PAD_LEFT);
        } else {
            return str_pad($newId, 5, '0', STR_PAD_LEFT);
        }
    }
}
