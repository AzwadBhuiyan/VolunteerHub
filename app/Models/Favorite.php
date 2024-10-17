<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['volunteer_userid', 'favorite_categories', 'favorite_districts'];

    protected $casts = [
        'favorite_categories' => 'array',
        'favorite_districts' => 'array',
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_userid', 'userid');
    }
}