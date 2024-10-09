<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Activity;
use Carbon\Carbon;

class ActivityTest extends TestCase
{
    public function test_calculate_priority_score()
    {
        $activity = new Activity([
            'min_volunteers' => 5,
            'deadline' => Carbon::now()->addDays(3),
            'created_at' => Carbon::now()->subDays(2),
        ]);

        // Mock the confirmedVolunteers relationship
        $activity->shouldReceive('confirmedVolunteers->count')->andReturn(3);

        $score = $activity->calculatePriorityScore();

        // Assert the expected score based on your calculation logic
        $this->assertEquals(38, $score); // -2 (for being 2 days old) + 40 (for being 3 days from deadline)
    }

    // Add more tests for different scenarios
}