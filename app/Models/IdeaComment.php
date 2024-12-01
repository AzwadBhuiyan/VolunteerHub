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

    public function getComment()
    {
        return $this->comment;
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_userid', 'userid');
    }

    public function votes()
    {
        return $this->hasMany(IdeaVote::class);
    }

    public function getVoteCount()
    {
        return $this->votes()->sum('vote');
    }

    public function hasVotedBy($userId)
    {
        return $this->votes()
            ->where('user_userid', $userId)
            ->where('idea_comment_id', $this->id)
            ->exists();
    }
}