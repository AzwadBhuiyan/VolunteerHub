<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $primaryKey = 'userid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'userid', 'Name', 'Phone', 'NID', 'Gender', 'DOB',
        'BloodGroup', 'PresentAddress', 'PermanentAddress', 'District',
        'TrainedInEmergencyResponse', 'Points', 'Badges', 'bio', 'url', 'profession'
    ];

    protected $casts = [
        'DOB' => 'date',
        'TrainedInEmergencyResponse' => 'boolean',
        'Points' => 'integer',
        'Badges' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function favoriteCategories()
    {
        return $this->belongsToMany(JobCategory::class, 'volunteer_favorite_categories', 'userid', 'category_id');
    }

    public function participatingActivities()
    {
        return $this->belongsToMany(Activity::class, 'activity_volunteers', 'volunteer_userid', 'activityid');
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

}