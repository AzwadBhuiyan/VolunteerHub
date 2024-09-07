<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityCategory extends Model
{
    protected $fillable = ['name'];

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'volunteer_favorite_categories', 'category_id', 'userid');
    }
}