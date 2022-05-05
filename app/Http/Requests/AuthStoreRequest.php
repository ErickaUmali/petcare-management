<?php

namespace App\Http\Requests;

use App\Rules\LettersOnly;
use App\Rules\NoSpecialChars;
use App\Rules\NumbersOnly;
use App\Rules\PasswordRule;
use App\Rules\UniqueContact;
use Illuminate\Foundation\Http\FormRequest;

class AuthStoreRequest extends FormRequest
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
            'firstname' => ['required', 'string', new LettersOnly],
            'lastname' => ['required', 'string', new LettersOnly],
            'contact' => ['required', 'string', 'min:9', 'max:9', new NumbersOnly, new UniqueContact],
            'username' => ['required', 'string', 'unique:users,username', new NoSpecialChars],
            'password' => ['required', 'string', 'min:8', 'max:25', 'confirmed', new PasswordRule],
            'security_question_id' => ['required', 'exists:security_questions,id'],
            'answer' => ['required', 'string']
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
            'answer.required' => 'Please enter a security answer.',
            'password.confirmed' => 'The passwords you entered do not match.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'contact' => 'contact number',
        ];
    }
}
