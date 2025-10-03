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
        User::create([
            'name' => 'John Doe',
            'email' => 'principal@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Principal',
        ]);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'adviser@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Adviser',
            'assigned_grade_level' => 'Grade 10',
        ]);
    }
}
