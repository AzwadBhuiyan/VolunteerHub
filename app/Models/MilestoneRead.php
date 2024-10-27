<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilestoneRead extends Model
{
    protected $fillable = ['milestone_id', 'volunteer_userid', 'is_read', 'read_at'];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function milestone()
    {
        return $this->belongsTo(ActivityMilestone::class, 'milestone_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_userid', 'userid');
    }
}