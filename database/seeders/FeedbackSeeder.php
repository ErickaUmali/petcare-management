<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 3)->get();
        $defaultFeedbacks = Feedback::getDefaultFeedbacks();

        $users->each(function ($user, $index) use ($defaultFeedbacks) {
            Feedback::factory()
                ->create([
                    'user_id' => $user->id,
                    'message' => $defaultFeedbacks[$index],
                    'stars' => rand(4, 5),
                ]);
        });
    }
}
