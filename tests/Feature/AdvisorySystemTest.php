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

class AdvisorySystemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function adviser_can_view_their_advisory_class()
    {
        $user = User::factory()->create(['role' => 'Adviser']);
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
            'assigned_grade_level' => '7',
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

        Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);

        $response = $this->actingAs($user)->get(route('advisory.index'));

        $response->assertStatus(200);
        $response->assertViewIs('advisory.index');
        $response->assertSee('Juan');
        $response->assertSee('Lanzones');
    }

    /** @test */
    public function teacher_without_advisory_sees_empty_state()
    {
        $user = User::factory()->create(['role' => 'Subject Teacher']);
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
        ]);

        $response = $this->actingAs($user)->get(route('advisory.index'));

        $response->assertStatus(200);
        $response->assertViewIs('advisory.index');
        $response->assertViewHas('advisorySection', null);
    }

    /** @test */
    public function adviser_can_search_students_in_their_class()
    {
        $user = User::factory()->create(['role' => 'Adviser']);
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
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

        $student1 = Student::create([
            'lrn' => '111111111111',
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $student2 = Student::create([
            'lrn' => '222222222222',
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Female',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        Enrollment::create([
            'student_id' => $student1->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);

        Enrollment::create([
            'student_id' => $student2->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);

        $response = $this->actingAs($user)
            ->get(route('advisory.index', ['search' => 'Juan']));

        $response->assertStatus(200);
        $response->assertSee('Juan');
        $response->assertDontSee('Maria');
    }

    /** @test */
    public function adviser_can_remove_student_from_advisory()
    {
        $user = User::factory()->create(['role' => 'Adviser']);
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
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
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);

        $response = $this->actingAs($user)
            ->delete(route('advisory.remove-student', $student->lrn));

        $response->assertRedirect(route('advisory.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enrollments', [
            'enrollment_id' => $enrollment->enrollment_id,
            'status' => 'Inactive',
            'section_id' => null,
        ]);
    }

    /** @test */
    public function adviser_cannot_remove_student_from_another_advisory()
    {
        // Create two advisers with different sections
        $adviser1 = User::factory()->create(['role' => 'Adviser']);
        $teacher1 = Teacher::create([
            'teacher_id' => $adviser1->id,
            'email' => $adviser1->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
        ]);

        $adviser2 = User::factory()->create(['role' => 'Adviser', 'email' => 'adviser2@test.com']);
        $teacher2 = Teacher::create([
            'teacher_id' => $adviser2->id,
            'email' => $adviser2->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
        ]);

        $section1 = Section::create([
            'grade_level' => '7',
            'name' => 'Lanzones',
            'adviser_teacher_id' => $teacher1->teacher_id,
        ]);

        $section2 = Section::create([
            'grade_level' => '7',
            'name' => 'Strawberry',
            'adviser_teacher_id' => $teacher2->teacher_id,
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

        // Enroll student in section2 (adviser2's section)
        Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'grade_level' => '7',
            'section_id' => $section2->section_id,
            'status' => 'Enrolled',
        ]);

        // Try to remove as adviser1
        $response = $this->actingAs($adviser1)
            ->delete(route('advisory.remove-student', $student->lrn));

        $response->assertSessionHas('error');
    }

    /** @test */
    public function adviser_can_sort_students_in_advisory()
    {
        $user = User::factory()->create(['role' => 'Adviser']);
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
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

        $student1 = Student::create([
            'lrn' => '999999999999',
            'first_name' => 'Zebra',
            'last_name' => 'Last',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $student2 = Student::create([
            'lrn' => '111111111111',
            'first_name' => 'Alpha',
            'last_name' => 'First',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        Enrollment::create([
            'student_id' => $student1->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);

        Enrollment::create([
            'student_id' => $student2->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);

        $response = $this->actingAs($user)
            ->get(route('advisory.index', ['sort_by' => 'name_asc']));

        $response->assertStatus(200);
    }

    /** @test */
    public function non_teacher_user_redirected_from_advisory()
    {
        $user = User::factory()->create(['role' => 'Subject Teacher']);
        // No teacher record created

        $response = $this->actingAs($user)->get(route('advisory.index'));

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function advisory_only_shows_enrolled_students()
    {
        $user = User::factory()->create(['role' => 'Adviser']);
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Adviser',
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

        $inactiveStudent = Student::create([
            'lrn' => '222222222222',
            'first_name' => 'Inactive',
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
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);

        Enrollment::create([
            'student_id' => $inactiveStudent->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Inactive',
        ]);

        $response = $this->actingAs($user)->get(route('advisory.index'));

        $response->assertStatus(200);
        $response->assertSee('Enrolled');
        $response->assertDontSee('Inactive');
    }
}