<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            SecurityQuestionSeeder::class,
            UserSeeder::class,
            SpeciesSeeder::class,
            BreedSeeder::class,
            DoctorSeeder::class,
            PetSeeder::class,
            AppointmentSeeder::class,
            ReservationSeeder::class,
            FeedbackSeeder::class,
        ]);
    }
}
