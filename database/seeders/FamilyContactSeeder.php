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
            'contact_id' => 1,
            'student_lrn' => '123456789012',
            'contact_type' => 'Father',
            'last_name' => 'Cruz',
            'first_name' => 'Pedro',
            'contact_number' => '09171234567',
        ]);

        FamilyContact::create([
            'contact_id' => 2,
            'student_lrn' => '123456789013',
            'contact_type' => 'Mother',
            'last_name' => 'Santos',
            'first_name' => 'Elena',
            'contact_number' => '09172345678',
        ]);
    }
}
