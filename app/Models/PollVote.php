<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    protected $guarded = [];

    protected $fillable = ['idea_thread_id', 'poll_option_id', 'user_id'];
    

    public function ideaPoll()
    {
        return $this->belongsTo(IdeaPoll::class);
    }

    public function pollOption()
    {
        return $this->belongsTo(PollOption::class);
    }
}
