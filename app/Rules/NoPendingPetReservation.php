<?php

namespace App\Rules;

use App\Models\Reservation;
use Illuminate\Contracts\Validation\Rule;

class NoPendingPetReservation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pendingReservations = Reservation::where([
            'pet_id' => $value,
            'status' => 0,
        ])->get();

        if ($pendingReservations->count() > 0) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This pet has an existing pending appointment.';
    }
}
