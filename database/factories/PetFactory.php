<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\Pet;
use App\Models\Species;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $species = Species::with('breeds')->inRandomOrder()->first();
        return [
            'user_id' => User::where('role', 3)->inRandomOrder()->first(),
            'species_id' => $species,
            'breed_id' => $species->breeds->random(),
            'name' => $this->faker->firstName,
            'birthday' => Pet::getRandomBirthday(),
            'gender' => Pet::getRandomGender(),
        ];
    }
}
