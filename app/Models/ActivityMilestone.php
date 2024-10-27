<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityMilestone extends Model
{
    protected $fillable = ['activity_id', 'message'];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'activityid');
    }

    public function reads()
    {
        return $this->hasMany(MilestoneRead::class, 'milestone_id');
    }
}