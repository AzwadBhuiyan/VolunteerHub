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
        'TrainedInEmergencyResponse', 'Points', 'Badges', 'bio'
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
}