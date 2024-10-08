<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class);
    }
}