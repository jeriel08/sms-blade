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
        Disability::create(['disability_id' => 1, 'name' => 'Visual Impairment (Blind)']);
        Disability::create(['disability_id' => 2, 'name' => 'Visual Impairment (Low Vision)']);
        Disability::create(['disability_id' => 3, 'name' => 'Hearing Impairment']);
        Disability::create(['disability_id' => 4, 'name' => 'Autism Spectrum Disorder']);
        Disability::create(['disability_id' => 5, 'name' => 'Multiple Disorder']);
        Disability::create(['disability_id' => 6, 'name' => 'Speech/Language Disorder']);
        Disability::create(['disability_id' => 7, 'name' => 'Learning Disability']);
        Disability::create(['disability_id' => 8, 'name' => 'Emotional-Behavior Disorder']);
        Disability::create(['disability_id' => 9, 'name' => 'Cerebral Palsy']);
        Disability::create(['disability_id' => 10, 'name' => 'Intellectual Disability']);
        Disability::create(['disability_id' => 11, 'name' => 'Orthopedic/Physical Handicap']);
        Disability::create(['disability_id' => 12, 'name' => 'Special Health Problem / Chronic Disease']);
    }
}
