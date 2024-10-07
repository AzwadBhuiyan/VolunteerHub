<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\ActivityCategory;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        // Get all categories from the ActivityCategory model
        $categories = ActivityCategory::pluck('name')->toArray();

        // Get districts from the config file
        $districts = config('districts.districts');

        $difficulties = ['easy', 'medium', 'hard', 'severe'];

        // Ensure we have categories and districts
        if (empty($categories)) {
            $this->command->error('No categories found. Please seed ActivityCategory table first.');
            return;
        }

        if (empty($districts)) {
            $this->command->error('No districts found in the config file.');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            $date = Carbon::now()->addDays(rand(1, 30));
            $deadline = Carbon::parse($date)->subDays(rand(1, 5));

            Activity::create([
                'userid' => 'org-001',
                'title' => 'Activity ' . ($i + 1),
                'description' => 'This is a description for Activity ' . ($i + 1),
                'date' => $date->format('Y-m-d'),
                'time' => $date->format('H:i:s'),
                'category' => $categories[array_rand($categories)],
                'district' => $districts[array_rand($districts)],
                'difficulty' => $difficulties[array_rand($difficulties)],
                'address' => 'Address for Activity ' . ($i + 1),
                'deadline' => $deadline->format('Y-m-d H:i:s'),
                'min_volunteers' => rand(5, 10),
                'max_volunteers' => rand(15, 30),
                'status' => 'open',
            ]);
        }
    }
}