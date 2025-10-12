<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Models\Address;
use App\Models\Enrollment;
use App\Models\FamilyContact;
use App\Models\Disability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function student_has_current_address_relationship(): void
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
            'is_disabled' => 1,
        ]);

        $disability1 = Disability::create(['name' => 'Visual Impairment']);
        $disability2 = Disability::create(['name' => 'Hearing Impairment']);

        $student->disabilities()->attach([$disability1->disability_id, $disability2->disability_id]);

        $this->assertCount(2, $student->disabilities);
        $this->assertInstanceOf(Disability::class, $student->disabilities->first());
    }

    /** @test */
    public function student_can_be_created_with_all_required_fields(): void
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
            'middle_name' => 'Middle',
            'last_name' => 'Doe',
            'extension_name' => 'Jr.',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'Test City',
            'sex' => 'Male',
            'mother_tounge' => 'Tagalog',
            'psa_birth_cert_no' => 'PSA-123456',
            'is_ip' => false,
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
            'is_disabled' => false,
        ]);

        $this->assertDatabaseHas('students', [
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('John', $student->first_name);
        $this->assertEquals('Middle', $student->middle_name);
        $this->assertEquals('Doe', $student->last_name);
    }

    /** @test */
    public function student_lrn_must_be_unique(): void
    {
        $address = Address::create([
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Test City',
            'province' => 'Test Province',
            'country' => 'Philippines',
        ]);

        Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'Test City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Student::create([
            'lrn' => '123456789012', // Duplicate LRN
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'Test City',
            'sex' => 'Female',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);
    }

    /** @test */
    public function student_can_have_ip_community_when_is_ip_is_true(): void
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
            'is_ip' => true,
            'ip_community' => 'Bagobo Tribe',
        ]);

        $this->assertTrue($student->is_ip);
        $this->assertEquals('Bagobo Tribe', $student->ip_community);
    }
}