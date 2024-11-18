<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaThread extends Model
{
    protected $fillable = ['userid', 'title', 'description', 'votes', 'status', 'winner_comment_id'];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'userid', 'userid');
    }

    public function comments()
    {
        return $this->hasMany(IdeaComment::class);
    }

    public function poll()
    {
        return $this->hasOne(IdeaPoll::class);
    }

    public function votes()
    {
        return $this->hasMany(IdeaVote::class);
    }

    public function getVoteCount()
    {
        return $this->votes()->whereNull('idea_comment_id')->sum('vote');
    }

    public function winnerComment()
    {
        return $this->belongsTo(IdeaComment::class, 'winner_comment_id');
    }

    public function allowsVoting()
    {
        return !$this->poll()->exists();
    }
}