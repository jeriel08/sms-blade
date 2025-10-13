<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Models\Address;
use App\Models\Enrollment;
use App\Models\FamilyContact;
use App\Models\Disability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function student_has_current_address(): void
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

        $this->assertInstanceOf(Address::class, $student->currentAddress);
    }

    /** @test */
    public function student_has_permanent_address(): void
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

        $this->assertInstanceOf(Address::class, $student->permanentAddress);
    }

    /** @test */
    public function student_has_many_family_contacts(): void
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

        FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Father',
            'first_name' => 'Dad',
            'last_name' => 'Doe',
            'contact_number' => '09123456789',
        ]);

        $this->assertCount(1, $student->familyContacts);
    }

    /** @test */
    public function student_has_many_enrollments(): void
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

        Enrollment::create([
            'student_id' => $student->student_id,
            'school_year' => '2024-2025',
            'enrollment_type' => 'New',
            'is_4ps' => 0,
        ]);

        $this->assertCount(1, $student->enrollments);
    }

    /** @test */
    public function student_has_many_disabilities(): void
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
            'is_disabled' => 1,
        ]);

        $disability = Disability::create(['name' => 'Visual Impairment']);
        $student->disabilities()->attach($disability->disability_id);

        $this->assertCount(1, $student->disabilities);
    }

    /** @test */
    public function lrn_must_be_unique(): void
    {
        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Student::create([
            'lrn' => '123456789012',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Female',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);
    }

    /** @test */
    public function ip_community_can_be_set_when_is_ip_true(): void
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
            'is_ip' => 1,
            'ip_community' => 'Bagobo',
        ]);

        $this->assertEquals('Bagobo', $student->ip_community);
        $this->assertTrue((bool)$student->is_ip);
    }
}