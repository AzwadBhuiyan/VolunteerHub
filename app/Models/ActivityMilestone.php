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

    public function markAsReadByVolunteer($volunteerUserId)
    {
        return $this->reads()
            ->where('volunteer_userid', $volunteerUserId)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }
}