<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $primaryKey = 'userid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'userid', 'name', 'contact', 'category', 'address', 'verification_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}