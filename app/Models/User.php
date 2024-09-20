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
        if ($userType === 'organization') {
            $lastOrg = self::where('userid', 'like', 'org-%')
                        ->orderBy('userid', 'desc')
                        ->first();
            $lastId = $lastOrg ? intval(substr($lastOrg->userid, 4)) : 0;
            $newId = $lastId + 1;
            return 'org-' . str_pad($newId, 3, '0', STR_PAD_LEFT);
        } else {
            $lastVolunteer = self::where('userid', 'not like', 'org-%')
                                ->orderBy('userid', 'desc')
                                ->first();
            $lastId = $lastVolunteer ? intval($lastVolunteer->userid) : 0;
            $newId = $lastId + 1;
            return str_pad($newId, 5, '0', STR_PAD_LEFT);
        }
    }
}
