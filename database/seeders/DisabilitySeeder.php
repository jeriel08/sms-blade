<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Disability;

class DisabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Disability::create(['disability_id' => 1, 'name' => 'Visual Impairment']);
        Disability::create(['disability_id' => 2, 'name' => 'Hearing Impairment']);
    }
}
