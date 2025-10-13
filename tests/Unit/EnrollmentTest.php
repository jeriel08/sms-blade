<?php

namespace Tests\Unit;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function enrollment_belongs_to_student(): void
    {
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
            'is_4ps' => 0,
        ]);

        $this->assertInstanceOf(Student::class, $enrollment->student);
        $this->assertEquals($student->student_id, $enrollment->student->student_id);
    }

    /** @test */
    public function enrollment_belongs_to_teacher(): void
    {
        $user = User::factory()->create();
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
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
            'enrolled_by_teacher_id' => $teacher->teacher_id,
            'is_4ps' => 0,
        ]);

        $this->assertInstanceOf(Teacher::class, $enrollment->teacher);
    }

    /** @test */
    public function enrollment_belongs_to_section(): void
    {
        $user = User::factory()->create();
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
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
            'is_4ps' => 0,
        ]);

        $this->assertInstanceOf(Section::class, $enrollment->section);
    }

    /** @test */
    public function enrollment_status_defaults_to_registered(): void
    {
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
            'is_4ps' => 0,
        ]);

        $this->assertEquals('Registered', $enrollment->status);
    }

    /** @test */
    public function enrollment_can_change_status_to_enrolled(): void
    {
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
            'is_4ps' => 0,
        ]);

        $enrollment->update(['status' => 'Enrolled']);

        $this->assertEquals('Enrolled', $enrollment->fresh()->status);
    }

    /** @test */
    public function transferee_enrollment_has_previous_school_info(): void
    {
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
            'enrollment_type' => 'Transferee',
            'last_grade_completed' => '6',
            'last_school_attended' => 'Previous School',
            'last_school_id' => 'SCH-123',
            'is_4ps' => 0,
        ]);

        $this->assertEquals('Transferee', $enrollment->enrollment_type);
        $this->assertEquals('Previous School', $enrollment->last_school_attended);
    }

    /** @test */
    public function enrollment_4ps_can_have_household_id(): void
    {
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
            'is_4ps' => 1,
            '_4ps_household_id' => 'HH-123456',
        ]);

        $this->assertTrue((bool)$enrollment->is_4ps);
        $this->assertEquals('HH-123456', $enrollment->_4ps_household_id);
    }
}