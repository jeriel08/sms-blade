<?php

namespace Tests\Unit;

use App\Models\Section;
use App\Models\Teacher;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function section_belongs_to_adviser(): void
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
        ]);

        $section = Section::create([
            'grade_level' => '7',
            'name' => 'Section A',
            'adviser_teacher_id' => $teacher->teacher_id,
        ]);

        $this->assertInstanceOf(Teacher::class, $section->adviser);
        $this->assertEquals($teacher->teacher_id, $section->adviser->teacher_id);
    }

    /** @test */
    public function section_has_many_enrollments(): void
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
        ]);

        $section = Section::create([
            'grade_level' => '7',
            'name' => 'Section A',
            'adviser_teacher_id' => $teacher->teacher_id,
        ]);

        $address = \App\Models\Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        $student = \App\Models\Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2024-2025',
            'enrollment_type' => 'New',
            'section_id' => $section->section_id,
            'is_4ps' => 0,
        ]);

        $this->assertCount(1, $section->enrollments);
    }

    /** @test */
    public function section_name_and_grade_level_must_be_unique(): void
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
        ]);

        Section::create([
            'grade_level' => '7',
            'name' => 'Section A',
            'adviser_teacher_id' => $teacher->teacher_id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Section::create([
            'grade_level' => '7',
            'name' => 'Section A',
            'adviser_teacher_id' => $teacher->teacher_id,
        ]);
    }

    /** @test */
    public function section_can_have_same_name_in_different_grade_levels(): void
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
        ]);

        $section1 = Section::create([
            'grade_level' => '7',
            'name' => 'Section A',
            'adviser_teacher_id' => $teacher->teacher_id,
        ]);

        $section2 = Section::create([
            'grade_level' => '8',
            'name' => 'Section A',
            'adviser_teacher_id' => $teacher->teacher_id,
        ]);

        $this->assertEquals('Section A', $section1->name);
        $this->assertEquals('Section A', $section2->name);
        $this->assertNotEquals($section1->section_id, $section2->section_id);
    }

    /** @test */
    public function section_can_exist_without_adviser(): void
    {
        $section = Section::create([
            'grade_level' => '7',
            'name' => 'Section A',
            'adviser_teacher_id' => null,
        ]);

        $this->assertNull($section->adviser_teacher_id);
        $this->assertNull($section->adviser);
    }
}