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
        Section::create(['grade_level' => '7', 'name' => 'Lanzones', 'adviser_teacher_id' => 2]);
        Section::create(['grade_level' => '7', 'name' => 'Strawberry', 'adviser_teacher_id' => 3]);
        Section::create(['grade_level' => '7', 'name' => 'Durian', 'adviser_teacher_id' => 4]);
        Section::create(['grade_level' => '8', 'name' => 'Rose', 'adviser_teacher_id' => 5]);
        Section::create(['grade_level' => '8', 'name' => 'Sunflower', 'adviser_teacher_id' => 6]);
        Section::create(['grade_level' => '8', 'name' => 'Marigold', 'adviser_teacher_id' => 7]);
        Section::create(['grade_level' => '9', 'name' => 'Amethyst', 'adviser_teacher_id' => 8]);
        Section::create(['grade_level' => '9', 'name' => 'Emerald', 'adviser_teacher_id' => 9]);
        Section::create(['grade_level' => '9', 'name' => 'Diamond', 'adviser_teacher_id' => 10]);
        Section::create(['grade_level' => '10', 'name' => 'Roxas', 'adviser_teacher_id' => 11]);
        Section::create(['grade_level' => '10', 'name' => 'Aguinaldo', 'adviser_teacher_id' => 12]);
        Section::create(['grade_level' => '10', 'name' => 'Rizal', 'adviser_teacher_id' => 13]);
        Section::create(['grade_level' => '11', 'name' => 'HUMSS-11-1', 'adviser_teacher_id' => 14]);
        Section::create(['grade_level' => '11', 'name' => 'ABM-11-1', 'adviser_teacher_id' => 15]);
        Section::create(['grade_level' => '11', 'name' => 'STEM-11-1', 'adviser_teacher_id' => 16]);
        Section::create(['grade_level' => '12', 'name' => 'STEM-12-1', 'adviser_teacher_id' => 17]);
        Section::create(['grade_level' => '12', 'name' => 'ABM-12-1', 'adviser_teacher_id' => 18]);
        Section::create(['grade_level' => '12', 'name' => 'HUMSS-12-1', 'adviser_teacher_id' => 19]);
    }
}
