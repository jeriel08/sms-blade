<?php

namespace Tests\Unit;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Section;
use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function teacher_belongs_to_user(): void
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
        ]);

        $this->assertInstanceOf(User::class, $teacher->user);
        $this->assertEquals($user->id, $teacher->user->id);
    }

    /** @test */
    public function teacher_has_many_enrollments(): void
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
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
            'enrolled_by_teacher_id' => $teacher->teacher_id,
            'is_4ps' => 0,
        ]);

        $this->assertCount(1, $teacher->enrollments);
    }

    /** @test */
    public function teacher_has_many_sections(): void
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

        Section::create([
            'grade_level' => '8',
            'name' => 'Section B',
            'adviser_teacher_id' => $teacher->teacher_id,
        ]);

        $this->assertCount(2, $teacher->sections);
    }

    /** @test */
    public function teacher_can_have_advisory_section(): void
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

        $this->assertInstanceOf(Section::class, $teacher->advisorySection);
        $this->assertEquals($section->section_id, $teacher->advisorySection->section_id);
    }

    /** @test */
    public function teacher_can_have_assigned_grade_level(): void
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
            'assigned_grade_level' => '7',
        ]);

        $this->assertEquals('7', $teacher->assigned_grade_level);
    }

    /** @test */
    public function teacher_has_different_roles(): void
    {
        $user = User::factory()->create();

        $roles = ['Principal', 'Head Teacher', 'Subject Teacher', 'Adviser'];

        foreach ($roles as $role) {
            $teacher = Teacher::create([
                'teacher_id' => $user->id + array_search($role, $roles),
                'email' => strtolower($role) . '@test.com',
                'password_hash' => bcrypt('password'),
                'role' => $role,
            ]);

            $this->assertEquals($role, $teacher->role);
        }
    }
}