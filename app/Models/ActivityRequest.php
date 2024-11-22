<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityRequest extends Model
{
    protected $fillable = [
        'volunteer_userid',
        'approved_by',
        'title',
        'description',
        'district',
        'status',
        'image',
        'activity_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    const STATUSES = [
        'pending',
        'in_progress',
        'approved',
        'rejected'
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_userid', 'userid');
    }

    public function approvedByOrganization()
    {
        return $this->belongsTo(Organization::class, 'approved_by', 'userid');
    }

    public static function getMonthlyRequestCount($volunteerUserId)
    {
        return self::where('volunteer_userid', $volunteerUserId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function getImagePath()
    {
        $imagePath = 'images/requests/' . $this->id . '.*';
        $fullImagePath = public_path($imagePath);
        $matchingFiles = glob($fullImagePath);
        
        if (!empty($matchingFiles)) {
            return 'images/requests/' . basename($matchingFiles[0]);
        }
        
        return 'images/defaults/default-activity-request.jpg';
    }
}