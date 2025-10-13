<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectionAssignmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function teacher_can_assign_grade_and_section_to_enrollment()
    {
        $user = User::factory()->create();
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Head Teacher',
        ]);

        $section = Section::create([
            'grade_level' => '7',
            'name' => 'Lanzones',
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
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'status' => 'Registered',
        ]);

        $response = $this->actingAs($user)
            ->post(route('enrollments.assign', $enrollment), [
                'grade_level' => '7',
                'section_id' => $section->section_id,
            ]);

        $response->assertRedirect(route('enrollments.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enrollments', [
            'enrollment_id' => $enrollment->enrollment_id,
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);
    }

    /** @test */
    public function assignment_validates_section_belongs_to_grade_level()
    {
        $user = User::factory()->create();
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Head Teacher',
        ]);

        // Create section for grade 8
        $section = Section::create([
            'grade_level' => '8',
            'name' => 'Rose',
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
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'status' => 'Registered',
        ]);

        // Try to assign grade 7 student to grade 8 section
        $response = $this->actingAs($user)
            ->post(route('enrollments.assign', $enrollment), [
                'grade_level' => '7',
                'section_id' => $section->section_id,
            ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function enrolled_student_status_changes_from_registered_to_enrolled()
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
            'name' => 'Lanzones',
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
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'status' => 'Registered',
        ]);

        $this->assertEquals('Registered', $enrollment->status);

        $this->actingAs($user)->post(route('enrollments.assign', $enrollment), [
            'grade_level' => '7',
            'section_id' => $section->section_id,
        ]);

        $enrollment->refresh();
        $this->assertEquals('Enrolled', $enrollment->status);
    }

    /** @test */
    public function system_tracks_which_teacher_enrolled_the_student()
    {
        $user = User::factory()->create();
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Head Teacher',
        ]);

        $section = Section::create([
            'grade_level' => '7',
            'name' => 'Lanzones',
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
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
        ]);

        $this->actingAs($user)->post(route('enrollments.assign', $enrollment), [
            'grade_level' => '7',
            'section_id' => $section->section_id,
        ]);

        $this->assertDatabaseHas('enrollments', [
            'enrollment_id' => $enrollment->enrollment_id,
            'enrolled_by_teacher_id' => $teacher->teacher_id,
        ]);
    }

    /** @test */
    public function guest_cannot_assign_sections()
    {
        $teacher = Teacher::create([
            'teacher_id' => 1,
            'email' => 'test@example.com',
            'password_hash' => bcrypt('password'),
            'role' => 'Head Teacher',
        ]);

        $section = Section::create([
            'grade_level' => '7',
            'name' => 'Lanzones',
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
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
        ]);

        $response = $this->post(route('enrollments.assign', $enrollment), [
            'grade_level' => '7',
            'section_id' => $section->section_id,
        ]);

        $response->assertRedirect(route('login'));
    }
}