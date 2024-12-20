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

    public function getProfileCompletionPercentage()
    {
        $fields = [
            // Required fields (50%)
            'required' => [
                'org_name' => ['Not Set'],
                'primary_address' => ['Not Set'],
                'org_mobile' => ['00000000000'],
                'description' => ['Not Set', null],
            ],
            // Optional fields (50%)
            'optional' => [
                'secondary_address' => ['Not Set'],
                'website' => ['http://example.com'],
                'org_telephone' => ['0000000'],
                'contact_email' => ['', null]
            ]
        ];

        // Calculate required fields completion (50%)
        $requiredCompleted = 0;
        foreach ($fields['required'] as $field => $defaultValues) {
            if (!empty($this->$field) && !in_array($this->$field, $defaultValues)) {
                $requiredCompleted++;
            }
        }
        $requiredPercentage = ($requiredCompleted / count($fields['required'])) * 50;

        // Calculate optional fields completion (50%)
        $optionalCompleted = 0;
        foreach ($fields['optional'] as $field => $defaultValues) {
            if (!empty($this->$field) && !in_array($this->$field, $defaultValues)) {
                $optionalCompleted++;
            }
        }
        $optionalPercentage = ($optionalCompleted / count($fields['optional'])) * 50;

        return min(100, round($requiredPercentage + $optionalPercentage));
    }

    public function getIncompleteFields()
    {
        $fields = [
            'org_name' => ['label' => 'Organization Name', 'default' => ['Not Set']],
            'primary_address' => ['label' => 'Primary Address', 'default' => ['Not Set']],
            'org_mobile' => ['label' => 'Mobile Number', 'default' => ['00000000000']],
            'description' => ['label' => 'Description', 'default' => ['Not Set', null]],
            'secondary_address' => ['label' => 'Secondary Address', 'default' => ['Not Set']],
            'website' => ['label' => 'Website', 'default' => ['http://example.com']],
            'org_telephone' => ['label' => 'Telephone', 'default' => ['0000000']],
            'contact_email' => ['label' => 'Contact Email', 'default' => ['', null]]
        ];

        $incomplete = [];
        foreach ($fields as $field => $config) {
            if (empty($this->$field) || in_array($this->$field, $config['default'])) {
                $incomplete[] = $config['label'];
            }
        }

        return $incomplete;
    }

    public function isProfileIncomplete()
    {
        return $this->getProfileCompletionPercentage() < 100;
    }
}