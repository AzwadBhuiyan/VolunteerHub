<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $primaryKey = 'userid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'userid', 'org_name', 'primary_address', 'secondary_address', 'website',
        'org_mobile', 'org_telephone', 'description', 'verification_status', 'url',
        'last_requests_read_at','contact_email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'userid', 'userid');
    }

    public function completedActivities()
    {
        return $this->activities()->where('status', 'completed')->latest();
    }

    // volunteer followers
    public function followers()
    {
        return $this->belongsToMany(Volunteer::class, 'volunteer_follows', 'followed_id', 'follower_id')
                    ->where('type', 'organization')
                    ->withTimestamps();
    }

    public function getLogoPath()
    {
        $logoPath = 'images/logos/' . $this->userid . '.*';
        $fullLogoPath = public_path($logoPath);
        $matchingFiles = glob($fullLogoPath);
        
        if (!empty($matchingFiles)) {
            // Return the path of the first matching file
            return 'images/logos/' . basename($matchingFiles[0]);
        }
        
        // Return the default logo path if no matching file is found
        return 'images/defaults/default-logo.png';
    }

    public function ideaThreads()
    {
        return $this->hasMany(IdeaThread::class, 'userid', 'userid');
    }

    public function getUnreadRequestsCount()
    {
        return ActivityRequest::where('status', 'pending')
            ->where('created_at', '>', $this->last_requests_read_at ?? now()->subYears(10))
            ->count();
    }

    public function markRequestsAsRead()
    {
        $this->update(['last_requests_read_at' => now()]);
    }
}