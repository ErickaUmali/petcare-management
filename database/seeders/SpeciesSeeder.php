<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultSpecies = Species::getRandomSpecies();

        $defaultSpecies->each(function ($species) {
            Species::factory()->create([
                'name' => $species,
            ]);
        });
    }
}
