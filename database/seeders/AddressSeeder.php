<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
            'address_id' => 1,
            'barangay' => 'Calinan Poblacion',
            'municipality_city' => 'Davao City',
            'province' => 'Davao Del Sur',
            'country' => 'Philippines',
            'zip_code' => '8000',
        ]);

        Address::create([
            'address_id' => 2,
            'barangay' => 'Mintal',
            'municipality_city' => 'Davao City',
            'province' => 'Davao Del Sur',
            'country' => 'Philippines',
            'zip_code' => '8000',
        ]);
    }
}
