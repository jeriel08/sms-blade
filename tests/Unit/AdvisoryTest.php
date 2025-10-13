<?php

namespace Tests\Unit;

use App\Models\Section;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvisoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function adviser_can_have_advisory_section(): void
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

        $this->assertEquals($teacher->teacher_id, $section->adviser_teacher_id);
    }

    /** @test */
    public function advisory_section_has_enrolled_students(): void
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

        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        $student = Student::create([
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
            'status' => 'Enrolled',
            'is_4ps' => 0,
        ]);

        $this->assertCount(1, $section->enrollments);
    }

    /** @test */
    public function student_can_be_removed_from_advisory_section(): void
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

        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        $student = Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2024-2025',
            'enrollment_type' => 'New',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
            'is_4ps' => 0,
        ]);

        $enrollment->update([
            'status' => 'Inactive',
            'section_id' => null,
        ]);

        $this->assertEquals('Inactive', $enrollment->fresh()->status);
        $this->assertNull($enrollment->fresh()->section_id);
    }

    /** @test */
    public function advisory_section_only_shows_enrolled_students(): void
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

        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        $student1 = Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $student2 = Student::create([
            'lrn' => '123456789013',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Female',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        Enrollment::create([
            'student_id' => $student1->student_id,
            'school_year' => '2024-2025',
            'enrollment_type' => 'New',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
            'is_4ps' => 0,
        ]);

        Enrollment::create([
            'student_id' => $student2->student_id,
            'school_year' => '2024-2025',
            'enrollment_type' => 'New',
            'section_id' => $section->section_id,
            'status' => 'Registered',
            'is_4ps' => 0,
        ]);

        $enrolledStudents = Enrollment::where('section_id', $section->section_id)
            ->where('status', 'Enrolled')
            ->count();

        $this->assertEquals(1, $enrolledStudents);
    }

    /** @test */
    public function teacher_without_advisory_has_no_section(): void
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
        ]);

        $this->assertNull($teacher->advisorySection);
    }
}