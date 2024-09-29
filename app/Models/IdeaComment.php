<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaComment extends Model
{
    protected $fillable = ['idea_thread_id', 'volunteer_userid', 'comment'];

    public function ideaThread()
    {
        return $this->belongsTo(IdeaThread::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_userid', 'userid');
    }
}