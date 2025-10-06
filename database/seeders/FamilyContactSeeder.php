<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FamilyContact;

class FamilyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FamilyContact::create([
            'student_id' => 1, // From StudentSeeder (auto 1)
            'contact_type' => 'Father',
            'last_name' => 'Cruz',
            'first_name' => 'Pedro',
            'contact_number' => '09171234567',
        ]);

        FamilyContact::create([
            'student_id' => 2, // From StudentSeeder (auto 2)
            'contact_type' => 'Mother',
            'last_name' => 'Santos',
            'first_name' => 'Elena',
            'contact_number' => '09172345678',
        ]);
    }
}
