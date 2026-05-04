<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('quizzes')->insert([
            [
                'question' => 'What is the capital of Indonesia?',
                'options' => json_encode(['Jakarta', 'Bandung', 'Surabaya', 'Medan']),
                'correct_answer' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'What is React Native?',
                'options' => json_encode(['A library', 'A framework', 'A language', 'A tool']),
                'correct_answer' => 'A framework',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Which company developed React?',
                'options' => json_encode(['Google', 'Apple', 'Meta', 'Microsoft']),
                'correct_answer' => 'Meta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
