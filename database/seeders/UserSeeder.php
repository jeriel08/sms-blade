<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Principal
        User::create([
            'name' => 'John Doe',
            'email' => 'principal@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Principal',
        ]);

        // Grade 7 Advisers
        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria.santos7a@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
        ]);
        User::create([
            'name' => 'Carlos Dela Cruz',
            'email' => 'carlos.delacruz7b@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
        ]);
        User::create([
            'name' => 'Angela Reyes',
            'email' => 'angela.reyes7c@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
        ]);
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe7d@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
        ]);

        // Grade 8 Advisers
        User::create([
            'name' => 'Patrick Mendoza',
            'email' => 'patrick.mendoza8a@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '8',
        ]);
        User::create([
            'name' => 'Liza Ramos',
            'email' => 'liza.ramos8b@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '8',
        ]);
        User::create([
            'name' => 'Erwin Bautista',
            'email' => 'erwin.bautista8c@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '8',
        ]);
        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe8d@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '8',
        ]);

        // Grade 9 Advisers
        User::create([
            'name' => 'Nina Cruz',
            'email' => 'nina.cruz9a@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '9',
        ]);
        User::create([
            'name' => 'Ramon Flores',
            'email' => 'ramon.flores9b@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '9',
        ]);
        User::create([
            'name' => 'Jenny Lim',
            'email' => 'jenny.lim9c@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '9',
        ]);
        User::create([
            'name' => 'Peter Parker',
            'email' => 'peter.parker9d@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '9',
        ]);

        // Grade 10 Advisers
        User::create([
            'name' => 'Allan Rivera',
            'email' => 'allan.rivera10a@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '10',
        ]);
        User::create([
            'name' => 'Bea Tan',
            'email' => 'bea.tan10b@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '10',
        ]);
        User::create([
            'name' => 'Samuel Ong',
            'email' => 'samuel.ong10c@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '10',
        ]);
        User::create([
            'name' => 'Clark Kent',
            'email' => 'clark.kent10d@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '10',
        ]);

        // Grade 11 Advisers
        User::create([
            'name' => 'Clara Bautista',
            'email' => 'clara.bautista11a@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '11',
        ]);
        User::create([
            'name' => 'Mark Chua',
            'email' => 'mark.chua11b@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '11',
        ]);
        User::create([
            'name' => 'Sophia Dizon',
            'email' => 'sophia.dizon11c@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '11',
        ]);
        User::create([
            'name' => 'Bruce Wayne',
            'email' => 'bruce.wayne11d@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '11',
        ]);

        // Grade 12 Advisers
        User::create([
            'name' => 'Joshua Navarro',
            'email' => 'joshua.navarro12a@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '12',
        ]);
        User::create([
            'name' => 'Ella Ramos',
            'email' => 'ella.ramos12b@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '12',
        ]);
        User::create([
            'name' => 'Miguel Santiago',
            'email' => 'miguel.santiago12c@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '12',
        ]);
        User::create([
            'name' => 'Diana Prince',
            'email' => 'diana.prince12d@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => '12',
        ]);
    }
}
