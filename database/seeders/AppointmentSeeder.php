<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultAppointments = Appointment::getDefaultAppointments();

        $defaultAppointments->each(function ($appointment) {
            Appointment::factory()
                ->create([
                    'name' => $appointment,
                ]);
        });
    }
}
