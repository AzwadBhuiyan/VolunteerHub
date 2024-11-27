<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorialProgress extends Model
{
    protected $fillable = ['userid', 'page_name', 'dont_show_again', 'last_step_seen'];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class, 'userid', 'userid');
    }
}