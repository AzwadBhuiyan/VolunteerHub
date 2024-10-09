<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Activity;
use App\Models\Organization;
use App\Models\Favorite;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_activities_are_sorted_by_priority_score()
    {
        // Create a user with a volunteer profile
        $user = User::factory()->create();
        $volunteer = Volunteer::factory()->create(['userid' => $user->userid]);

        // Create an organization
        $organization = Organization::factory()->create();

        // Create favorite categories and districts
        Favorite::create([
            'volunteer_userid' => $volunteer->userid,
            'favorite_categories' => ['Category1', 'Category2'],
            'favorite_districts' => ['District1', 'District2'],
        ]);

        // Create activities with different priority scores
        $highPriorityActivity = Activity::factory()->create([
            'userid' => $organization->userid,
            'category' => 'Category1',
            'district' => 'District1',
            'status' => 'open',
            'deadline' => now()->addDays(2),
            'created_at' => now()->subDays(1),
        ]);

        $lowPriorityActivity = Activity::factory()->create([
            'userid' => $organization->userid,
            'category' => 'Category2',
            'district' => 'District2',
            'status' => 'open',
            'deadline' => now()->addDays(10),
            'created_at' => now()->subDays(5),
        ]);

        // Authenticate the user
        $this->actingAs($user);

        // Make a request to the showFavorites method
        $response = $this->get(route('favorites.show'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the activities are in the correct order
        $response->assertSeeInOrder([
            $highPriorityActivity->title,
            $lowPriorityActivity->title,
        ]);
    }

    public function test_only_open_activities_are_shown()
    {
        // Similar setup as above, but include both open and closed activities
        // ...

        $response = $this->get(route('favorites.show'));

        $response->assertStatus(200);
        $response->assertSee($openActivity->title);
        $response->assertDontSee($closedActivity->title);
    }

    public function test_activities_match_favorite_categories_and_districts()
    {
        // Similar setup, but create activities with matching and non-matching categories/districts
        // ...

        $response = $this->get(route('favorites.show'));

        $response->assertStatus(200);
        $response->assertSee($matchingActivity->title);
        $response->assertDontSee($nonMatchingActivity->title);
    }
}