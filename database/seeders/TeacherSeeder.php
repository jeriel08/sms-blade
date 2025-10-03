<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Link to User IDs (assuming User IDs are 1 and 2 from UserSeeder)
        Teacher::create([
            'teacher_id' => 1,
            'email' => 'principal@example.com',
            'password_hash' => '', // Not used, handled by User
            'role' => 'Principal',
            'assigned_grade_level' => 'Grade 12',
        ]);

        Teacher::create([
            'teacher_id' => 2,
            'email' => 'adviser@example.com',
            'password_hash' => '', // Not used, handled by User
            'role' => 'Adviser',
            'assigned_grade_level' => 'Grade 10',
        ]);
    }
}
