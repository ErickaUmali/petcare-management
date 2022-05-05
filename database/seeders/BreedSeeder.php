<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $canineBreeds = Breed::getCanineBreeds();

        $canineBreeds->each(function ($breed) {
            Breed::factory()
                ->create([
                    'species_id' => 1,
                    'name' => $breed,
                ]);
        });

        $felineBreeds = Breed::getFelineBreeds();

        $felineBreeds->each(function ($breed) {
            Breed::factory()
                ->create([
                    'species_id' => 2,
                    'name' => $breed,
                ]);
        });
    }
}
