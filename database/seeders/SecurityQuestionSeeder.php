<?php

namespace Database\Seeders;

use App\Models\SecurityQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecurityQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = SecurityQuestion::getDefaultQuestions();

        $questions->each(function ($question) {
            SecurityQuestion::factory()->create([
                'question' => $question,
            ]);
        });
    }
}
