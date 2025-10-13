<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Address;
use App\Models\FamilyContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_students_index()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('students.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('students.index');
    }

    /** @test */
    public function user_can_search_students_by_name()
    {
        $user = User::factory()->create();
        
        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        $student1 = Student::create([
            'lrn' => '123456789012',
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $student2 = Student::create([
            'lrn' => '987654321098',
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Female',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('students.index', ['search' => 'Juan']));

        $response->assertStatus(200);
        $response->assertSee('Juan');
        $response->assertDontSee('Maria');
    }

    /** @test */
    public function user_can_search_students_by_lrn()
    {
        $user = User::factory()->create();
        
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

        $response = $this->actingAs($user)
            ->get(route('students.index', ['search' => '123456789012']));

        $response->assertStatus(200);
        $response->assertSee('123456789012');
        $response->assertSee('Juan');
    }

    /** @test */
    public function user_can_filter_students_by_enrollment_status()
    {
        $user = User::factory()->create();
        
        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        $enrolledStudent = Student::create([
            'lrn' => '111111111111',
            'first_name' => 'Enrolled',
            'last_name' => 'Student',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $registeredStudent = Student::create([
            'lrn' => '222222222222',
            'first_name' => 'Registered',
            'last_name' => 'Student',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        Enrollment::create([
            'student_id' => $enrolledStudent->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'status' => 'Enrolled',
        ]);

        Enrollment::create([
            'student_id' => $registeredStudent->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'status' => 'Registered',
        ]);

        $response = $this->actingAs($user)
            ->get(route('students.index', ['status' => 'enrolled']));

        $response->assertStatus(200);
        $response->assertSee('Enrolled');
    }

    /** @test */
    public function user_can_view_student_profile()
    {
        $user = User::factory()->create();
        
        $address = Address::create([
            'barangay' => 'Calinan',
            'municipality_city' => 'Davao City',
            'province' => 'Davao Del Sur',
            'country' => 'Philippines',
        ]);

        $student = Student::create([
            'lrn' => '123456789012',
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'middle_name' => 'Santos',
            'birthdate' => '2008-05-15',
            'place_of_birth' => 'Davao City',
            'sex' => 'Male',
            'mother_tounge' => 'Bisaya',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Father',
            'first_name' => 'Pedro',
            'last_name' => 'Cruz',
            'contact_number' => '09171234567',
        ]);

        $response = $this->actingAs($user)
            ->get(route('students.show', $student->lrn));

        $response->assertStatus(200);
        $response->assertViewIs('students.show');
        $response->assertSee('Juan');
        $response->assertSee('Dela Cruz');
        $response->assertSee('123456789012');
    }

    /** @test */
    public function user_can_edit_student_information()
    {
        $user = User::factory()->create();
        
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

        $response = $this->actingAs($user)
            ->get(route('students.edit', $student->lrn));

        $response->assertStatus(200);
        $response->assertViewIs('students.edit');
    }

    /** @test */
    public function user_can_update_student_information()
    {
        $user = User::factory()->create();
        
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

        $response = $this->actingAs($user)
            ->put(route('students.update', $student->lrn), [
                'first_name' => 'John',
                'last_name' => 'Cruz',
                'middle_name' => 'Dela',
                'birthdate' => '2008-01-01',
                'sex' => 'Male',
                'place_of_birth' => 'Davao City',
                'mother_tongue' => 'Bisaya',
                'is_ip' => 0,
                'is_disabled' => 0,
            ]);

        $response->assertRedirect(route('students.show', $student->lrn));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'lrn' => '123456789012',
            'first_name' => 'John',
        ]);
    }

    /** @test */
    public function user_can_enroll_student_from_student_index()
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

        $response = $this->actingAs($user)
            ->post(route('students.enroll', $student->lrn), [
                'grade_level' => '7',
                'section_id' => $section->section_id,
            ]);

        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enrollments', [
            'student_id' => $student->student_id,
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);
    }

    /** @test */
    public function user_can_view_student_academic_record()
    {
        $user = User::factory()->create();
        
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

        $response = $this->actingAs($user)
            ->get(route('students.academic-record', $student->lrn));

        $response->assertStatus(200);
        $response->assertViewIs('students.academic-record');
        $response->assertSee('Academic Record');
    }

    /** @test */
    public function user_can_sort_students_by_different_criteria()
    {
        $user = User::factory()->create();
        
        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        Student::create([
            'lrn' => '999999999999',
            'first_name' => 'Zebra',
            'last_name' => 'Last',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        Student::create([
            'lrn' => '111111111111',
            'first_name' => 'Alpha',
            'last_name' => 'First',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        // Test name sorting
        $response = $this->actingAs($user)
            ->get(route('students.index', ['sort_by' => 'name_asc']));
        $response->assertStatus(200);

        // Test LRN sorting
        $response = $this->actingAs($user)
            ->get(route('students.index', ['sort_by' => 'lrn_asc']));
        $response->assertStatus(200);
    }
}