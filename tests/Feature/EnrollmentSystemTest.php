<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Address;
use App\Models\FamilyContact;
use App\Models\Disability;
use App\Models\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Set up school year
        Settings::create(['key' => 'school_year', 'value' => '2025-2026']);
        
        // Create disabilities
        Disability::insert([
            ['name' => 'Visual Impairment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hearing Impairment', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /** @test */
    public function authenticated_user_can_view_enrollment_index_page()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('enrollments.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('enrollments.index');
    }

    /** @test */
    public function guest_cannot_access_enrollment_pages()
    {
        $response = $this->get(route('enrollments.index'));
        
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_complete_new_student_enrollment_workflow()
    {
        $user = User::factory()->create();
        $teacher = Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
        ]);

        // Step 1: Access create enrollment page
        $response = $this->actingAs($user)
            ->get(route('enrollments.create', ['type' => 'new', 'step' => 'learner']));
        
        $response->assertStatus(200);
        $response->assertViewIs('enrollments.create');

        // Step 2: Submit learner information
        $learnerData = [
            'action' => 'next',
            'student_type' => 'new',
            'school_year' => '2025-2026',
            'with_lrn' => 1,
            'returning' => 0,
            'lrn' => '123456789012',
            'first_name' => 'Juan',
            'middle_name' => 'Dela',
            'last_name' => 'Cruz',
            'extension_name' => 'Jr.',
            'birthdate' => '2008-05-15',
            'place_of_birth' => 'Davao City',
            'age' => 17,
            'gender' => 'male',
            'mother_tongue' => 'Bisaya',
            'psa_birth_certification_no' => 'ABC123',
            'ip_community_member' => 0,
            'ip_community' => null,
            '4ps_beneficiary' => 0,
            '4ps_household_id' => null,
            'is_disabled' => 0,
        ];

        $response = $this->actingAs($user)
            ->post(route('enrollments.create', ['type' => 'new', 'step' => 'learner']), $learnerData);
        
        $response->assertRedirect(route('enrollments.create', ['type' => 'new', 'step' => 'address']));

        // Step 3: Submit address information
        $addressData = [
            'action' => 'next',
            'house_number' => '123',
            'street_name' => 'Main Street',
            'barangay' => 'Calinan Poblacion',
            'city' => 'Davao City',
            'province' => 'Davao Del Sur',
            'country' => 'Philippines',
            'zip_code' => '8000',
            'same_as_current_address' => 1,
        ];

        $response = $this->actingAs($user)
            ->post(route('enrollments.create', ['type' => 'new', 'step' => 'address']), $addressData);
        
        $response->assertRedirect(route('enrollments.create', ['type' => 'new', 'step' => 'guardian']));

        // Step 4: Submit guardian information
        $guardianData = [
            'action' => 'next',
            'father_first_name' => 'Pedro',
            'father_last_name' => 'Cruz',
            'father_middle_name' => 'Santos',
            'father_contact_number' => '09171234567',
            'mother_first_name' => 'Maria',
            'mother_last_name' => 'Cruz',
            'mother_middle_name' => 'Reyes',
            'mother_contact_number' => '09181234567',
        ];

        $response = $this->actingAs($user)
            ->post(route('enrollments.create', ['type' => 'new', 'step' => 'guardian']), $guardianData);
        
        $response->assertRedirect(route('enrollments.create', ['type' => 'new', 'step' => 'review']));

        // Step 5: Review and submit
        $reviewData = [
            'action' => 'submit',
            'declaration' => 1,
        ];

        $response = $this->actingAs($user)
            ->post(route('enrollments.create', ['type' => 'new', 'step' => 'review']), $reviewData);
        
        $response->assertRedirect(route('enrollments.index'));
        $response->assertSessionHas('success', 'Student enrolled successfully!');

        // Verify database records
        $this->assertDatabaseHas('students', [
            'lrn' => '123456789012',
            'first_name' => 'Juan',
            'last_name' => 'Cruz',
        ]);

        $student = Student::where('lrn', '123456789012')->first();
        
        $this->assertDatabaseHas('enrollments', [
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'new',
            'status' => 'Registered',
        ]);

        $this->assertDatabaseHas('family_contacts', [
            'student_id' => $student->student_id,
            'contact_type' => 'father',
            'first_name' => 'Pedro',
        ]);
    }

    /** @test */
    public function user_can_complete_transferee_enrollment_with_previous_school_info()
    {
        $user = User::factory()->create();
        Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
        ]);

        // Submit all steps including school history
        $this->actingAs($user)->post(route('enrollments.create', ['type' => 'transferee', 'step' => 'learner']), [
            'action' => 'next',
            'student_type' => 'transferee',
            'school_year' => '2025-2026',
            'with_lrn' => 1,
            'returning' => 0,
            'lrn' => '987654321098',
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'birthdate' => '2009-03-20',
            'place_of_birth' => 'Manila',
            'age' => 16,
            'gender' => 'female',
            'mother_tongue' => 'Tagalog',
            'ip_community_member' => 0,
            '4ps_beneficiary' => 0,
            'is_disabled' => 0,
        ]);

        $this->actingAs($user)->post(route('enrollments.create', ['type' => 'transferee', 'step' => 'address']), [
            'action' => 'next',
            'street_name' => 'School Road',
            'barangay' => 'Mintal',
            'city' => 'Davao City',
            'province' => 'Davao Del Sur',
            'country' => 'Philippines',
            'zip_code' => '8000',
            'same_as_current_address' => 1,
        ]);

        $this->actingAs($user)->post(route('enrollments.create', ['type' => 'transferee', 'step' => 'guardian']), [
            'action' => 'next',
            'father_first_name' => 'Jose',
            'father_last_name' => 'Santos',
            'father_contact_number' => '09171111111',
            'mother_first_name' => 'Elena',
            'mother_last_name' => 'Santos',
            'mother_contact_number' => '09182222222',
        ]);

        // School history step (unique to transferee)
        $this->actingAs($user)->post(route('enrollments.create', ['type' => 'transferee', 'step' => 'school']), [
            'action' => 'next',
            'last_grade_level_completed' => '6',
            'last_school_year_completed' => '2024-2025',
            'last_school_attended' => 'Manila Elementary School',
            'school_id' => 'SCH-123',
            'semester' => 'second_sem',
        ]);

        $response = $this->actingAs($user)->post(route('enrollments.create', ['type' => 'transferee', 'step' => 'review']), [
            'action' => 'submit',
            'declaration' => 1,
        ]);

        $response->assertRedirect(route('enrollments.index'));

        $student = Student::where('lrn', '987654321098')->first();
        $this->assertNotNull($student);

        $this->assertDatabaseHas('enrollments', [
            'student_id' => $student->student_id,
            'enrollment_type' => 'transferee',
            'last_school_attended' => 'Manila Elementary School',
            'last_grade_level' => '6',
        ]);
    }

    /** @test */
    public function enrollment_validation_prevents_duplicate_lrn()
    {
        $user = User::factory()->create();
        Teacher::create([
            'teacher_id' => $user->id,
            'email' => $user->email,
            'password_hash' => bcrypt('password'),
            'role' => 'Subject Teacher',
        ]);

        // Create existing student
        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        Student::create([
            'lrn' => '111111111111',
            'first_name' => 'Existing',
            'last_name' => 'Student',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        // Try to enroll with duplicate LRN
        $response = $this->actingAs($user)
            ->post(route('enrollments.create', ['type' => 'new', 'step' => 'learner']), [
                'action' => 'next',
                'student_type' => 'new',
                'school_year' => '2025-2026',
                'with_lrn' => 1,
                'returning' => 0,
                'lrn' => '111111111111', // Duplicate
                'first_name' => 'Another',
                'last_name' => 'Student',
                'birthdate' => '2008-05-15',
                'age' => 17,
                'gender' => 'male',
                'mother_tongue' => 'Bisaya',
                'ip_community_member' => 0,
                '4ps_beneficiary' => 0,
                'is_disabled' => 0,
            ]);

        $response->assertSessionHasErrors('lrn');
    }

    /** @test */
    public function user_can_search_enrollments()
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

        Enrollment::create([
            'student_id' => $student1->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
        ]);

        Enrollment::create([
            'student_id' => $student2->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
        ]);

        $response = $this->actingAs($user)
            ->get(route('enrollments.index', ['search' => 'Juan']));

        $response->assertStatus(200);
        $response->assertSee('Juan');
        $response->assertDontSee('Maria');
    }

    /** @test */
    public function user_can_sort_enrollments()
    {
        $user = User::factory()->create();
        
        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        $student1 = Student::create([
            'lrn' => '111111111111',
            'first_name' => 'Zebra',
            'last_name' => 'Last',
            'birthdate' => '2008-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $student2 = Student::create([
            'lrn' => '222222222222',
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
        ]);

        Enrollment::create([
            'student_id' => $student2->student_id,
            'school_year' => '2025-2026',
            'enrollment_type' => 'New',
        ]);

        $response = $this->actingAs($user)
            ->get(route('enrollments.index', ['sort_by' => 'name_asc']));

        $response->assertStatus(200);
        
        // Verify order (Alpha should come before Zebra)
        $content = $response->getContent();
        $posAlpha = strpos($content, 'Alpha');
        $posZebra = strpos($content, 'Zebra');
        
        $this->assertLessThan($posZebra, $posAlpha);
    }
}