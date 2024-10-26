<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $fillable = ['idea_poll_id', 'option_text', 'votes'];

    public function ideaPoll()
    {
        return $this->belongsTo(IdeaPoll::class);
    }

    public function getPercentage()
    {
        $totalVotes = $this->ideaPoll->getTotalVotes();
        return $totalVotes > 0 ? ($this->votes / $totalVotes) * 100 : 0;
    }

    public function hasVotedBy($userId)
    {
        return $this->ideaPoll->votes()->where('user_id', $userId)
            ->where('poll_option_id', $this->id)
            ->exists();
    }
}