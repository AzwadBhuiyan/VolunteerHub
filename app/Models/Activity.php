<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $primaryKey = 'activityid';

    protected $fillable = [
        'userid', 'title', 'description', 'date', 'time', 'category',
        'district', 'address', 'deadline', 'min_volunteers', 'max_volunteers', 'status',
        'accomplished_description', 'duration', 'difficulty', 'points'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'deadline' => 'datetime',
    ];

    const STATUSES = ['open', 'closed', 'completed', 'cancelled'];

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
        return $this->confirmedVolunteers()->count();
    }

    public function shouldBeClosed()
    {
        return ($this->max_volunteers && $this->confirmed_volunteers_count >= $this->max_volunteers) ||
               ($this->deadline && now() > $this->deadline);
    }

    public function close()
    {
        $this->update(['status' => 'closed']);
    }
}