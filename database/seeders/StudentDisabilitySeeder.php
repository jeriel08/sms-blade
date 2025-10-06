<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentDisabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('student_disabilities')->insert([
            [
                'disability_id' => 1, // Visual Impairment
                'student_id' => 1, // Juan Cruz
            ],
        ]);
    }
}
