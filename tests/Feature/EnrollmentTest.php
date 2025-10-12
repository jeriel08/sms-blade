<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Address;
use App\Models\Disability;
use App\Models\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate
        $this->user = User::factory()->create([
            'role' => 'Subject Teacher',
        ]);

        // Create school year setting
        Settings::create([
            'key' => 'school_year',
            'value' => '2024-2025',
        ]);
    }

    /** @test */
    public function enrollment_index_page_can_be_accessed(): void
    {
        $response = $this->actingAs($this->user)->get(route('enrollments.index'));

        $response->assertStatus(200);
        $response->assertViewIs('enrollments.index');
    }

    /** @test */
    public function enrollment_create_page_can_be_accessed(): void
    {
        $response = $this->actingAs($this->user)->get(route('enrollments.create'));

        $response->assertStatus(200);
        $response->assertViewIs('enrollments.create');
    }

    /** @test */
    public function enrollment_defaults_to_new_student_type(): void
    {
        $response = $this->actingAs($this->user)->get(route('enrollments.create'));

        $response->assertStatus(200);
        $response->assertViewHas('studentType', 'new');
        $response->assertViewHas('currentStep', 'learner');
    }

    /** @test */
    public function enrollment_can_start_with_transferee_type(): void
    {
        $response = $this->actingAs($this->user)->get(route('enrollments.create', ['type' => 'transferee']));

        $response->assertStatus(200);
        $response->assertViewHas('studentType', 'transferee');
    }

    /** @test */
    public function learner_information_step_requires_required_fields(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'learner']), [
                'action' => 'next',
            ]);

        $response->assertSessionHasErrors([
            'student_type',
            'school_year',
            'with_lrn',
            'returning',
            'first_name',
            'last_name',
            'birthdate',
            'gender',
            'age',
            'ip_community_member',
            '4ps_beneficiary',
            'is_disabled',
        ]);
    }

    /** @test */
    public function learner_step_validates_lrn_format(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'learner']), [
                'student_type' => 'new',
                'school_year' => '2024-2025',
                'with_lrn' => 1,
                'lrn' => '123', // Invalid LRN (must be 12 digits)
                'returning' => 0,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'birthdate' => '2010-01-01',
                'gender' => 'male',
                'age' => 14,
                'ip_community_member' => 0,
                '4ps_beneficiary' => 0,
                'is_disabled' => 0,
                'action' => 'next',
            ]);

        $response->assertSessionHasErrors(['lrn']);
    }

    /** @test */
    public function learner_step_validates_unique_lrn(): void
    {
        // Create existing student with LRN
        $address = Address::create([
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Test City',
            'province' => 'Test Province',
            'country' => 'Philippines',
        ]);

        Student::create([
            'lrn' => '123456789012',
            'first_name' => 'Existing',
            'last_name' => 'Student',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'Test City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'learner']), [
                'student_type' => 'new',
                'school_year' => '2024-2025',
                'with_lrn' => 1,
                'lrn' => '123456789012', // Duplicate LRN
                'returning' => 0,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'birthdate' => '2010-01-01',
                'gender' => 'male',
                'age' => 14,
                'ip_community_member' => 0,
                '4ps_beneficiary' => 0,
                'is_disabled' => 0,
                'action' => 'next',
            ]);

        $response->assertSessionHasErrors(['lrn']);
    }

    /** @test */
    public function address_step_requires_required_fields(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'address']), [
                'action' => 'next',
            ]);

        $response->assertSessionHasErrors([
            'street_name',
            'barangay',
            'city',
            'province',
            'country',
            'zip_code',
            'same_as_current_address',
        ]);
    }

    /** @test */
    public function guardian_step_requires_parent_information(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'guardian']), [
                'action' => 'next',
            ]);

        $response->assertSessionHasErrors([
            'father_last_name',
            'father_first_name',
            'father_contact_number',
            'mother_last_name',
            'mother_first_name',
            'mother_contact_number',
        ]);
    }

    /** @test */
    public function complete_enrollment_creates_student_and_enrollment(): void
    {
        // Step 1: Learner Info
        $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'learner']), [
                'student_type' => 'new',
                'school_year' => '2024-2025',
                'with_lrn' => 1,
                'lrn' => '123456789012',
                'returning' => 0,
                'first_name' => 'John',
                'middle_name' => 'Middle',
                'last_name' => 'Doe',
                'birthdate' => '2010-01-01',
                'place_of_birth' => 'Test City',
                'gender' => 'male',
                'age' => 14,
                'mother_tongue' => 'Tagalog',
                'ip_community_member' => 0,
                '4ps_beneficiary' => 0,
                'is_disabled' => 0,
                'action' => 'next',
            ]);

        // Step 2: Address Info
        $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'address']), [
                'house_number' => '123',
                'street_name' => 'Main Street',
                'barangay' => 'Test Barangay',
                'city' => 'Test City',
                'province' => 'Test Province',
                'country' => 'Philippines',
                'zip_code' => '8000',
                'same_as_current_address' => 1,
                'action' => 'next',
            ]);

        // Step 3: Guardian Info
        $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'guardian']), [
                'father_first_name' => 'Father',
                'father_last_name' => 'Doe',
                'father_contact_number' => '09123456789',
                'mother_first_name' => 'Mother',
                'mother_last_name' => 'Doe',
                'mother_contact_number' => '09123456780',
                'action' => 'next',
            ]);

        // Step 4: Review and Submit
        $response = $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'review']), [
                'declaration' => 1,
                'action' => 'submit',
            ]);

        // Assert student was created
        $this->assertDatabaseHas('students', [
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        // Assert enrollment was created
        $this->assertDatabaseHas('enrollments', [
            'school_year' => '2024-2025',
            'enrollment_type' => 'new',
        ]);

        // Assert addresses were created
        $this->assertDatabaseHas('addresses', [
            'street_name' => 'Main Street',
            'barangay' => 'Test Barangay',
        ]);

        // Assert family contacts were created
        $this->assertDatabaseHas('family_contacts', [
            'contact_type' => 'father',
            'first_name' => 'Father',
        ]);

        $this->assertDatabaseHas('family_contacts', [
            'contact_type' => 'mother',
            'first_name' => 'Mother',
        ]);

        $response->assertRedirect(route('enrollments.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function transferee_enrollment_includes_school_step(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('enrollments.create', ['type' => 'transferee', 'step' => 'school']));

        $response->assertStatus(200);
        $response->assertViewHas('currentStep', 'school');
    }

    /** @test */
    public function enrollment_can_be_assigned_grade_and_section(): void
    {
        // Create section
        $teacher = Teacher::create([
            'teacher_id' => $this->user->id,
            'email' => $this->user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
        ]);

        $section = Section::create([
            'grade_level' => '7',
            'name' => 'Section A',
            'adviser_teacher_id' => $teacher->teacher_id,
        ]);

        // Create student and enrollment
        $address = Address::create([
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Test City',
            'province' => 'Test Province',
            'country' => 'Philippines',
        ]);

        $student = Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'Test City',
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

        $response = $this->actingAs($this->user)
            ->post(route('enrollments.assign', $enrollment), [
                'grade_level' => '7',
                'section_id' => $section->section_id,
            ]);

        $this->assertDatabaseHas('enrollments', [
            'enrollment_id' => $enrollment->enrollment_id,
            'grade_level' => '7',
            'section_id' => $section->section_id,
            'status' => 'Enrolled',
        ]);

        $response->assertRedirect(route('enrollments.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function enrollment_with_disabilities_creates_pivot_records(): void
    {
        // Create disabilities
        $disability1 = Disability::create(['name' => 'Visual Impairment']);
        $disability2 = Disability::create(['name' => 'Hearing Impairment']);

        // Step 1: Learner Info with disabilities
        $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'learner']), [
                'student_type' => 'new',
                'school_year' => '2024-2025',
                'with_lrn' => 1,
                'lrn' => '123456789012',
                'returning' => 0,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'birthdate' => '2010-01-01',
                'place_of_birth' => 'Test City',
                'gender' => 'male',
                'age' => 14,
                'ip_community_member' => 0,
                '4ps_beneficiary' => 0,
                'is_disabled' => 1,
                'disabilities' => [
                    $disability1->disability_id => '1',
                    $disability2->disability_id => '1',
                ],
                'action' => 'next',
            ]);

        // Complete remaining steps...
        $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'address']), [
                'street_name' => 'Main Street',
                'barangay' => 'Test Barangay',
                'city' => 'Test City',
                'province' => 'Test Province',
                'country' => 'Philippines',
                'zip_code' => '8000',
                'same_as_current_address' => 1,
                'action' => 'next',
            ]);

        $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'guardian']), [
                'father_first_name' => 'Father',
                'father_last_name' => 'Doe',
                'father_contact_number' => '09123456789',
                'mother_first_name' => 'Mother',
                'mother_last_name' => 'Doe',
                'mother_contact_number' => '09123456780',
                'action' => 'next',
            ]);

        $this->actingAs($this->user)
            ->post(route('enrollments.create', ['step' => 'review']), [
                'declaration' => 1,
                'action' => 'submit',
            ]);

        // Assert student disabilities were created
        $student = Student::where('lrn', '123456789012')->first();
        $this->assertDatabaseHas('student_disabilities', [
            'student_id' => $student->student_id,
            'disability_id' => $disability1->disability_id,
        ]);

        $this->assertDatabaseHas('student_disabilities', [
            'student_id' => $student->student_id,
            'disability_id' => $disability2->disability_id,
        ]);
    }

    /** @test */
    public function enrollment_index_displays_enrollments_with_search(): void
    {
        $address = Address::create([
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Test City',
            'province' => 'Test Province',
            'country' => 'Philippines',
        ]);

        $student = Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'Test City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2024-2025',
            'enrollment_type' => 'New',
            'is_4ps' => 0,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('enrollments.index', ['search' => 'John']));

        $response->assertStatus(200);
        $response->assertSee('John');
        $response->assertSee('Doe');
    }

    /** @test */
    public function enrollment_settings_page_requires_authorization(): void
    {
        // Regular teacher should not access settings
        $response = $this->actingAs($this->user)->get(route('enrollments.settings'));

        $response->assertStatus(200);
        $response->assertViewHas('canAccessSettings', false);
    }

    /** @test */
    public function principal_can_access_enrollment_settings(): void
    {
        $principal = User::factory()->create(['role' => 'Principal']);

        $response = $this->actingAs($principal)->get(route('enrollments.settings'));

        $response->assertStatus(200);
        $response->assertViewHas('canAccessSettings', true);
    }
}