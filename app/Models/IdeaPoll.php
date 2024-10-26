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

    public function getTotalVotes()
    {
        return $this->options->sum('votes');
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class, 'idea_thread_id', 'idea_thread_id');
    }

    public function hasVotedBy($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }
}
