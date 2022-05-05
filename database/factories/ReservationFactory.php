<?php

namespace Database\Factories;

use App\Helpers\ReservationHelper;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $reservation = new ReservationHelper;

        return [
            'user_id' => 1,
            'pet_id' => 1,
            'doctor_id' => Doctor::inRandomOrder()->first(),
            'appointment_id' => Appointment::inRandomOrder()->first(),
            'status' => 1,
            'date' => $reservation->getRandomValidDate(),
            'time' => $reservation->getAvailableTime(),
            'reference' => ReservationHelper::generateUniqueReference(),
        ];
    }
}
