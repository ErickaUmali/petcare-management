<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 3)->get();

        $users->each(function ($user) {
            $limit = rand(1, 5);

            for ($i = 0; $i < $limit; $i++) {
                Pet::factory()->create([
                    'user_id' => $user->id,
                ]);
            }
        });
    }
}
