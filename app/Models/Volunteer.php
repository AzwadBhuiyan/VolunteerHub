<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMilestoneReads;

class Volunteer extends Model
{
    // milestone notifications
    use HasMilestoneReads;

    protected $primaryKey = 'userid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'userid', 'Name', 'Phone', 'NID', 'Gender', 'DOB',
        'BloodGroup', 'PresentAddress', 'PermanentAddress', 'District',
        'TrainedInEmergencyResponse', 'Points', 'Badges', 'bio', 'url', 'allow_follow', 'profession'
    ];

    protected $casts = [
        'DOB' => 'date',
        'TrainedInEmergencyResponse' => 'boolean',
        'allow_follow' => 'boolean',
        'Points' => 'integer',
        'Badges' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function getProfilePicturePath()
    {
        $imagePath = 'images/profile_pictures/' . $this->userid . '.*';
        $matchingFiles = glob(public_path($imagePath));
        $profilePicture = !empty($matchingFiles) ? basename($matchingFiles[0]) : null;
        
        return $profilePicture 
            ? asset('images/profile_pictures/' . $profilePicture) 
            : asset('images/defaults/default-avatar.png');
    }

    public function favorite()
    {
        return $this->hasOne(Favorite::class, 'volunteer_userid', 'userid');
    }

    public function participatingActivities()
    {
        return $this->belongsToMany(Activity::class, 'activity_volunteers', 'volunteer_userid', 'activityid');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_volunteers', 'volunteer_userid', 'activityid')
                    ->withPivot('approval_status', 'visibility')
                    ->withTimestamps();
    }
    

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // calculate level
    // change as needed
    public function getLevel()
    {
        if ($this->Points >= 101) return '5';
        if ($this->Points >= 51) return '4';
        if ($this->Points >= 31) return '3';
        if ($this->Points >= 11) return '2';
        return '1';
    }

    // for filter according to level
    public static function getLevelPoints($level)
    {
        switch ($level) {
            case '5':
                return ['min' => 101, 'max' => PHP_INT_MAX];
            case '4':
                return ['min' => 51, 'max' => 101];
            case '3':
                return ['min' => 31, 'max' => 51];
            case '2':
                return ['min' => 11, 'max' => 31];
            default:
                return ['min' => 0, 'max' => 11];
        }
    }

    // follow organizations
    public function followedOrganizations()
    {
        return $this->belongsToMany(Organization::class, 'volunteer_follows', 'follower_id', 'followed_id')
                    ->where('type', 'organization')
                    ->withTimestamps();
    }
    
    public function followedVolunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'volunteer_follows', 'follower_id', 'followed_id')
                    ->where('type', 'volunteer')
                    ->withTimestamps();
    }
    
    public function followers()
    {
        return $this->belongsToMany(Volunteer::class, 'volunteer_follows', 'followed_id', 'follower_id')
                    ->where('type', 'volunteer')
                    ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(IdeaComment::class, 'volunteer_userid', 'userid');
    }

    public function pollVotes()
    {
        return $this->hasMany(PollVote::class, 'user_id', 'userid');
    }

    public function getIdeaInteractionsCountAttribute()
    {
        return $this->comments()->count() + $this->pollVotes()->count();
    }

    // Profile Completion
    // need to revisit the specifics
    public function getProfileCompletionPercentage()
    {
        $fields = [
            // Required fields (40%)
            'required' => [
                'Name' => ['Not Set'],
                'Phone' => ['Not Set'],
                'Gender' => ['Not Set'],
                'DOB' => ['1900-01-01'],
                'PresentAddress' => ['Not Set'],
                'District' => ['Not Set']
            ],
            // Optional fields (60%)
            'optional' => [
                'PermanentAddress' => ['Not Set'],
                'NID' => ['Not Set'],
                'BloodGroup' => ['Not Set'],
                'profession' => ['', null],
                'bio' => ['', null],
            ]
        ];

        // Calculate required fields completion (40%)
        $requiredCompleted = 0;
        foreach ($fields['required'] as $field => $defaultValues) {
            if (!empty($this->$field) && !in_array($this->$field, $defaultValues)) {
                $requiredCompleted++;
            }
        }
        $requiredPercentage = ($requiredCompleted / count($fields['required'])) * 40;

        // Calculate optional fields completion (60%)
        $optionalCompleted = 0;
        foreach ($fields['optional'] as $field => $defaultValues) {
            if (!empty($this->$field) && !in_array($this->$field, $defaultValues)) {
                $optionalCompleted++;
            }
        }
        $optionalPercentage = ($optionalCompleted / count($fields['optional'])) * 60;

        return min(100, round($requiredPercentage + $optionalPercentage));
    }

    public function getIncompleteFields()
    {
        $fields = [
            'Name' => ['label' => 'Full Name', 'default' => ['Not Set']],
            'Phone' => ['label' => 'Phone Number', 'default' => ['Not Set']],
            'Gender' => ['label' => 'Gender', 'default' => ['Not Set']],
            'DOB' => ['label' => 'Date of Birth', 'default' => ['1900-01-01']],
            'PresentAddress' => ['label' => 'Present Address', 'default' => ['Not Set']],
            'District' => ['label' => 'District', 'default' => ['Not Set']],
            'PermanentAddress' => ['label' => 'Permanent Address', 'default' => ['Not Set']],
            'NID' => ['label' => 'NID', 'default' => ['Not Set']],
            'BloodGroup' => ['label' => 'Blood Group', 'default' => ['Not Set']],
            'profession' => ['label' => 'Profession', 'default' => ['', null],],
            'bio' => ['label' => 'Bio', 'default' => ['', null],]
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

    //Activity Request
    public function activityRequests()
    {
        return $this->hasMany(ActivityRequest::class, 'volunteer_userid', 'userid');
    }

    //probably double function created check volunteer_dashboard php code
    public function canMakeRequest()
    {
        $level = $this->getLevel();
        $monthlyLimit = match($level) {
            '2' => 1,
            '3', '4' => 3,
            '5' => 5,
            default => 0
        };

        $currentRequests = ActivityRequest::getMonthlyRequestCount($this->userid);
        return $currentRequests < $monthlyLimit;
    }
}