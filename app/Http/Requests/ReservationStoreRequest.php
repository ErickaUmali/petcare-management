<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use App\Rules\NoPendingPetReservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pet_id' => ['required', 'exists:pets,id', new NoPendingPetReservation],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_id' => ['required', 'exists:appointments,id'],
            'date' => ['required', 'date'],
            'time' => ['required', Rule::in(Reservation::getAvailableTimes())],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'pet_id.required' => 'You have no existing pets. Please add a pet first.',
        ];
    }
}
