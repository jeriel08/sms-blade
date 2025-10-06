<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create(['grade_level' => 'Grade 7', 'name' => 'Lanzones']);
        Section::create(['grade_level' => 'Grade 7', 'name' => 'Strawberry']);
        Section::create(['grade_level' => 'Grade 7', 'name' => 'Durian']);
        Section::create(['grade_level' => 'Grade 8', 'name' => 'Rose']);
        Section::create(['grade_level' => 'Grade 8', 'name' => 'Sunflower']);
        Section::create(['grade_level' => 'Grade 8', 'name' => 'Marigold']);
        Section::create(['grade_level' => 'Grade 9', 'name' => 'Amethyst']);
        Section::create(['grade_level' => 'Grade 9', 'name' => 'Emerald']);
        Section::create(['grade_level' => 'Grade 9', 'name' => 'Diamond']);
        Section::create(['grade_level' => 'Grade 10', 'name' => 'Roxas']);
        Section::create(['grade_level' => 'Grade 10', 'name' => 'Aguinaldo']);
        Section::create(['grade_level' => 'Grade 10', 'name' => 'Rizal']);
        Section::create(['grade_level' => 'Grade 11', 'name' => 'HUMSS-11-1']);
        Section::create(['grade_level' => 'Grade 11', 'name' => 'ABM-11-1']);
        Section::create(['grade_level' => 'Grade 11', 'name' => 'STEM-11-1']);
        Section::create(['grade_level' => 'Grade 12', 'name' => 'STEM-12-1']);
        Section::create(['grade_level' => 'Grade 12', 'name' => 'ABM-12-1']);
        Section::create(['grade_level' => 'Grade 12', 'name' => 'HUMSS-12-1']);
    }
}
