<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $primaryKey = 'userid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'userid', 'name', 'contact', 'category', 'address', 'verification_status',
        'description', 'website'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'userid', 'userid');
    }
}