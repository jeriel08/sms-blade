<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Principal
        Teacher::create([
            'teacher_id' => 1,
            'email' => 'principal@example.com',
            'password_hash' => '', // Not used, handled by User
            'role' => 'Principal',
            'assigned_grade_level' => '12',
        ]);

        // Grade 7 Advisers
        Teacher::create([
            'teacher_id' => 2,
            'email' => 'maria.santos7a@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
        ]);
        Teacher::create([
            'teacher_id' => 3,
            'email' => 'carlos.delacruz7b@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
        ]);
        Teacher::create([
            'teacher_id' => 4,
            'email' => 'angela.reyes7c@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
        ]);
        Teacher::create([
            'teacher_id' => 20,
            'email' => 'john.doe7d@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
        ]);

        // Grade 8 Advisers
        Teacher::create([
            'teacher_id' => 5,
            'email' => 'patrick.mendoza8a@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '8',
        ]);
        Teacher::create([
            'teacher_id' => 6,
            'email' => 'liza.ramos8b@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '8',
        ]);
        Teacher::create([
            'teacher_id' => 7,
            'email' => 'erwin.bautista8c@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '8',
        ]);
        Teacher::create([
            'teacher_id' => 21,
            'email' => 'jane.doe8d@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '8',
        ]);

        // Grade 9 Advisers
        Teacher::create([
            'teacher_id' => 8,
            'email' => 'nina.cruz9a@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '9',
        ]);
        Teacher::create([
            'teacher_id' => 9,
            'email' => 'ramon.flores9b@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '9',
        ]);
        Teacher::create([
            'teacher_id' => 10,
            'email' => 'jenny.lim9c@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '9',
        ]);
        Teacher::create([
            'teacher_id' => 22,
            'email' => 'peter.parker9d@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '9',
        ]);

        // Grade 10 Advisers
        Teacher::create([
            'teacher_id' => 11,
            'email' => 'allan.rivera10a@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '10',
        ]);
        Teacher::create([
            'teacher_id' => 12,
            'email' => 'bea.tan10b@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '10',
        ]);
        Teacher::create([
            'teacher_id' => 13,
            'email' => 'samuel.ong10c@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '10',
        ]);
        Teacher::create([
            'teacher_id' => 23,
            'email' => 'clark.kent10d@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '10',
        ]);

        // Grade 11 Advisers
        Teacher::create([
            'teacher_id' => 14,
            'email' => 'clara.bautista11a@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '11',
        ]);
        Teacher::create([
            'teacher_id' => 15,
            'email' => 'mark.chua11b@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '11',
        ]);
        Teacher::create([
            'teacher_id' => 16,
            'email' => 'sophia.dizon11c@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '11',
        ]);
        Teacher::create([
            'teacher_id' => 24,
            'email' => 'bruce.wayne11d@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '11',
        ]);

        // Grade 12 Advisers
        Teacher::create([
            'teacher_id' => 17,
            'email' => 'joshua.navarro12a@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '12',
        ]);
        Teacher::create([
            'teacher_id' => 18,
            'email' => 'ella.ramos12b@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '12',
        ]);
        Teacher::create([
            'teacher_id' => 19,
            'email' => 'miguel.santiago12c@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '12',
        ]);
        Teacher::create([
            'teacher_id' => 25,
            'email' => 'diana.prince12d@example.com',
            'password_hash' => '',
            'role' => 'Adviser',
            'assigned_grade_level' => '12',
        ]);
    }
}
