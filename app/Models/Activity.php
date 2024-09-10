<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $primaryKey = 'activityid';

    protected $fillable = [
        'userid', 'title', 'description', 'date', 'time', 'category',
        'district', 'address', 'deadline', 'min_volunteers', 'max_volunteers', 'status'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'deadline' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'userid', 'userid');
    }

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'activity_volunteers', 'activityid', 'volunteer_userid')
                    ->withPivot('approval_status')
                    ->withTimestamps();
    }
}