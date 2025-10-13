<?php

namespace Tests\Unit;

use App\Models\FamilyContact;
use App\Models\Student;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function family_contact_belongs_to_student(): void
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

        $contact = FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Father',
            'first_name' => 'Dad',
            'last_name' => 'Doe',
            'contact_number' => '09123456789',
        ]);

        $this->assertInstanceOf(Student::class, $contact->student);
        $this->assertEquals($student->student_id, $contact->student->student_id);
    }

    /** @test */
    public function family_contact_has_different_types(): void
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

        $father = FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Father',
            'first_name' => 'Dad',
            'last_name' => 'Doe',
            'contact_number' => '09123456789',
        ]);

        $mother = FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Mother',
            'first_name' => 'Mom',
            'last_name' => 'Doe',
            'contact_number' => '09123456788',
        ]);

        $guardian = FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Guardian',
            'first_name' => 'Guardian',
            'last_name' => 'Smith',
            'contact_number' => '09123456787',
        ]);

        $this->assertEquals('Father', $father->contact_type);
        $this->assertEquals('Mother', $mother->contact_type);
        $this->assertEquals('Guardian', $guardian->contact_type);
    }

    /** @test */
    public function student_can_have_multiple_family_contacts(): void
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

        FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Mother',
            'first_name' => 'Mom',
            'last_name' => 'Doe',
            'contact_number' => '09123456788',
        ]);

        $this->assertCount(2, $student->familyContacts);
    }

    /** @test */
    public function family_contact_can_have_middle_name(): void
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

        $contact = FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Father',
            'first_name' => 'John',
            'middle_name' => 'Michael',
            'last_name' => 'Doe',
            'contact_number' => '09123456789',
        ]);

        $this->assertEquals('Michael', $contact->middle_name);
    }

    /** @test */
    public function family_contact_middle_name_is_optional(): void
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

        $contact = FamilyContact::create([
            'student_id' => $student->student_id,
            'contact_type' => 'Father',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'contact_number' => '09123456789',
        ]);

        $this->assertNull($contact->middle_name);
    }
}