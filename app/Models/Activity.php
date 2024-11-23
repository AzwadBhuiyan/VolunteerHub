<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $primaryKey = 'activityid';

    protected $fillable = [
        'userid', 'title', 'description', 'date', 'time', 'category',
        'district', 'address', 'deadline', 'min_volunteers', 'max_volunteers', 'status',
        'accomplished_description', 'duration', 'difficulty', 'points','required_profession',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'deadline' => 'datetime',
    ];

    const STATUSES = ['open', 'closed', 'completed', 'cancelled'];

    public function category()
    {
        return $this->belongsTo(ActivityCategory::class, 'category');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'userid');
    }

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'activity_volunteers', 'activityid', 'volunteer_userid')
                    ->withPivot('approval_status')
                    ->withTimestamps();
    }

    // Activity timeline milestones
    public function milestones()
    {
        return $this->hasMany(ActivityMilestone::class, 'activity_id', 'activityid')
                    ->orderBy('created_at', 'asc');
    }

    public function pendingVolunteers()
    {
        return $this->volunteers()->wherePivot('approval_status', 'pending');
    }

    public function confirmedVolunteers()
    {
        return $this->volunteers()->wherePivot('approval_status', 'approved');
    }

    public function getPendingVolunteersCountAttribute()
    {
        return $this->pendingVolunteers()->count();
    }

    public function getConfirmedVolunteersCountAttribute()
    {
        return $this->volunteers()->wherePivot('approval_status', 'approved')->count();
    }


    public function close()
    {
        $this->update(['status' => 'closed']);
    }
    

    public function getVolunteerStatus($volunteerUserId)
    {
        $volunteer = $this->volunteers()->where('volunteer_userid', $volunteerUserId)->first();
        return $volunteer ? $volunteer->pivot->approval_status : null;
    }

    public function calculatePriorityScore()
    {
        $score = 0;

        // Recency score: newer activities get higher scores
        // Each day old = -1 point
        $score += $this->created_at->diffInDays(now(), false) * -1;

        // Check if minimum volunteer count is reached
        $confirmedCount = $this->confirmedVolunteers()->count();
        if ($confirmedCount >= $this->min_volunteers) {
            $score -= 50; // Activities that have reached their minimum volunteer count lose 50 points
        } else {
            // Higher priority if close to deadline and minimum count not reached
            // (e.g., 3 days until deadline adds 40 points: (7 - 3) * 10)
            // Maximum bonus: 60 points (for activities due today)
            // Minimum bonus: 0 points (for activities due in 7 or more days)
            $daysUntilDeadline = now()->diffInDays($this->deadline, false);
            if ($daysUntilDeadline <= 7) {
                $score += (7 - $daysUntilDeadline) * 10;
            }
        }

        // The final score is a combination of recency, volunteer count, and urgency
        // Higher scores indicate higher priority for display or notifications
        return $score;
    }

    public function scopeOrderByPriority($query)
    {
        return $query->orderByRaw('
            CASE 
                WHEN (SELECT COUNT(*) FROM activity_volunteers 
                    WHERE activity_volunteers.activityid = activities.activityid 
                    AND approval_status = "approved") >= activities.min_volunteers THEN -50
                WHEN DATEDIFF(activities.deadline, NOW()) <= 7 
                    THEN (7 - DATEDIFF(activities.deadline, NOW())) * 10
                ELSE 0
            END - DATEDIFF(NOW(), activities.created_at) DESC
        ');
    }
    
}