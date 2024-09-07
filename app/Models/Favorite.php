<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
}