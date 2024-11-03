<?php

namespace App\Traits;

trait HasMilestoneReads
{
    public function getUnreadMilestonesCount($activityId = null)
    {
        $query = \DB::table('milestone_reads')
            ->join('activity_milestones', 'milestone_reads.milestone_id', '=', 'activity_milestones.id')
            ->where('milestone_reads.volunteer_userid', $this->userid)
            ->where('milestone_reads.is_read', false);

        if ($activityId) {
            $query->where('activity_milestones.activity_id', $activityId);
        }

        return $query->count();
    }
}