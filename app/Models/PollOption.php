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
}