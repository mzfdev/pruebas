<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'carnet' => '20210001',
                'name' => 'Juan',
                'lastname' => 'Pérez García',
                'email' => 'juan.perez@universidad.edu'
            ],
            [
                'carnet' => '20210002',
                'name' => 'María',
                'lastname' => 'López Hernández',
                'email' => 'maria.lopez@universidad.edu'
            ],
            [
                'carnet' => '20210003',
                'name' => 'Carlos',
                'lastname' => 'Rodríguez Martínez',
                'email' => 'carlos.rodriguez@universidad.edu'
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}