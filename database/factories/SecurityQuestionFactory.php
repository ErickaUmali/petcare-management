<?php

namespace Database\Factories;

use App\Models\SecurityQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SecurityQuestion>
 */
class SecurityQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'question' => SecurityQuestion::getDefaultQuestions()->random(),
        ];
    }
}
