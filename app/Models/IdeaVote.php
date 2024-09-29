<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaVote extends Model
{
    protected $fillable = ['idea_thread_id', 'user_userid', 'vote'];

    public function ideaThread()
    {
        return $this->belongsTo(IdeaThread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_userid', 'userid');
    }
}