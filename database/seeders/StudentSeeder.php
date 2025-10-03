<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'lrn' => '123456789012',
            'last_name' => 'Cruz',
            'first_name' => 'Juan',
            'middle_name' => 'Dela',
            'extension_name' => 'Jr.',
            'birthdate' => '2008-05-15',
            'place_of_birth' => 'Davao City',
            'sex' => 'Male',
            'mother_tounge' => 'Bisaya',
            'psa_birth_cert_no' => 'ABC123XYZ',
            'is_ip' => 0,
            'ip_community' => null,
            'current_address_id' => 1,
            'permanent_address_id' => 1,
            'is_disabled' => 1,
        ]);

        Student::create([
            'lrn' => '123456789013',
            'last_name' => 'Santos',
            'first_name' => 'Maria',
            'middle_name' => 'Clara',
            'birthdate' => '2009-03-20',
            'place_of_birth' => 'Davao City',
            'sex' => 'Female',
            'mother_tounge' => 'Bisaya',
            'psa_birth_cert_no' => 'DEF456XYZ',
            'is_ip' => 0,
            'ip_community' => null,
            'current_address_id' => 2,
            'permanent_address_id' => 2,
            'is_disabled' => 0,
        ]);
    }
}
