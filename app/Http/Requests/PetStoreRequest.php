<?php

namespace App\Http\Requests;

use App\Rules\LettersOnly;
use Illuminate\Foundation\Http\FormRequest;

class PetStoreRequest extends FormRequest
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
            'name' => ['required', 'string', new LettersOnly],
            'birthday' => ['required', 'date'],
            'gender' => ['required'],
            'species_id' => ['required'],
            'breed_id' => ['required'],
            'marking' => ['nullable',  new LettersOnly],
        ];
    }
}