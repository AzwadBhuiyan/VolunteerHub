<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaPoll extends Model
{
    protected $fillable = ['idea_thread_id', 'question'];

    public function ideaThread()
    {
        return $this->belongsTo(IdeaThread::class);
    }

    public function options()
    {
        return $this->hasMany(PollOption::class);
    }
}