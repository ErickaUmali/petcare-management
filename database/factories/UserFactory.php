<?php

namespace Database\Factories;

use App\Helpers\UserHelper;
use App\Models\SecurityQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $firstname = $this->faker->firstName;
        $lastname = $this->faker->lastName;

        return [
            'role' => User::getRandomRole(),
            'profile' => null,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'contact' => User::getRandomContact(),
            'username' => Str::lower($lastname . $firstname) . UserHelper::numbers(rand(0, 2)),
            'password' => User::getDefaultPassword(),
            'security_question_id' => SecurityQuestion::inRandomOrder()->first(),
            'answer' => $this->faker->word,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
