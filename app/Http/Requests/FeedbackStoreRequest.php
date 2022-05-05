<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'stars' => ['required', 'numeric', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'min:10', 'max:130'],
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
            'stars.required' => 'Please choose how many stars you want to rate us',
            'message.required' => 'Please enter your feedback message.',
            'message.min' => 'Your feedback message is too short.',
            'message.max' => 'Your feedback message is too long.',
        ];
    }
}
