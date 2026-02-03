<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inscription;
use App\Models\Student;
use App\Models\Subject;
use App\Models\InscriptionStatus;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student1 = Student::where('carnet', '20210001')->first();
        $student2 = Student::where('carnet', '20210002')->first();
        $student3 = Student::where('carnet', '20210003')->first();
        
        $subject1 = Subject::where('code', 'MAT101')->first();
        $subject2 = Subject::where('code', 'INF102')->first();
        $subject3 = Subject::where('code', 'FIS101')->first();
        
        $activeStatus = InscriptionStatus::where('code', 'active')->first();
        $inactiveStatus = InscriptionStatus::where('code', 'inactive')->first();

        $inscriptions = [
            [
                'student_id' => $student1->id,
                'subject_id' => $subject1->id,
                'inscription_status_id' => $activeStatus->id,
                'qualification' => 85.50,
                'coursed_times' => 1
            ],
            [
                'student_id' => $student1->id,
                'subject_id' => $subject2->id,
                'inscription_status_id' => $activeStatus->id,
                'qualification' => 92.00,
                'coursed_times' => 1
            ],
            [
                'student_id' => $student2->id,
                'subject_id' => $subject1->id,
                'inscription_status_id' => $activeStatus->id,
                'qualification' => 78.25,
                'coursed_times' => 1
            ],
            [
                'student_id' => $student2->id,
                'subject_id' => $subject3->id,
                'inscription_status_id' => $activeStatus->id,
                'qualification' => null,
                'coursed_times' => 1
            ],
            [
                'student_id' => $student3->id,
                'subject_id' => $subject2->id,
                'inscription_status_id' => $activeStatus->id,
                'qualification' => 88.75,
                'coursed_times' => 1
            ],
            [
                'student_id' => $student3->id,
                'subject_id' => $subject3->id,
                'inscription_status_id' => $inactiveStatus->id,
                'qualification' => null,
                'coursed_times' => 1
            ],
        ];

        foreach ($inscriptions as $inscription) {
            Inscription::create($inscription);
        }
    }
}