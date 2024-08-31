<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'userid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'userid', 'email', 'password',
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
}
