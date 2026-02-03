<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'code' => 'MAT101',
                'name' => 'Matemáticas I',
                'uv' => 4,
                'parent_id' => null
            ],
            [
                'code' => 'INF102',
                'name' => 'Programación I',
                'uv' => 4,
                'parent_id' => null
            ],
            [
                'code' => 'FIS101',
                'name' => 'Física I',
                'uv' => 4,
                'parent_id' => null
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}