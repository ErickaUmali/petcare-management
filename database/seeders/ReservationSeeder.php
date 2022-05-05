<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::with('pets')->where('role', 3)->get();

        $users->each(function ($user) {
            foreach ($user->pets as $pet) {
                $limit = rand(2, 6);

                for ($i = 0; $i < $limit; $i++) {
                    Reservation::factory()->create([
                        'user_id' => $user->id,
                        'pet_id' => $pet->id,
                    ]);
                }
            }
        });
    }
}
