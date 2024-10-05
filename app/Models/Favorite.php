<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'districts'];

    protected $casts = [
        'districts' => 'array',
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ActivityCategory::class, 'volunteer_favorite_categories', 'volunteer_id', 'category_id');
    }
}