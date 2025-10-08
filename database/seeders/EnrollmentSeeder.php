<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enrollment::create([
            'student_id' => 1,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'enrolled_by_teacher_id' => 2, // Adviser
            'enrollment_date' => now(),
        ]);

        Enrollment::create([
            'student_id' => 2,
            'school_year' => '2025-2026',
            'enrollment_type' => 'Transferee',
            'enrolled_by_teacher_id' => 2, // Adviser
            'enrollment_date' => now(),
        ]);
    }
}
