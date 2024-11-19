<?php

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;

class CloseExpiredActivities extends Command
{
    protected $signature = 'activities:close-expired';
    protected $description = 'Close activities that have reached their deadline';

    public function handle()
    {
        Activity::where('status', 'open')
            ->whereDate('deadline', '<=', now())
            ->update(['status' => 'closed']);

        $this->info('Expired activities have been closed.');
    }
}