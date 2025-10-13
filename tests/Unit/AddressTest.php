<?php

namespace Tests\Unit;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function address_can_be_created_with_required_fields(): void
    {
        $address = Address::create([
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Davao City',
            'province' => 'Davao del Sur',
            'country' => 'Philippines',
        ]);

        $this->assertDatabaseHas('addresses', [
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Davao City',
        ]);
    }

    /** @test */
    public function address_can_have_optional_fields(): void
    {
        $address = Address::create([
            'house_no' => '123',
            'street_name' => 'Main Street',
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Davao City',
            'province' => 'Davao del Sur',
            'country' => 'Philippines',
            'zip_code' => '8000',
        ]);

        $this->assertEquals('123', $address->house_no);
        $this->assertEquals('Main Street', $address->street_name);
        $this->assertEquals('8000', $address->zip_code);
    }

    /** @test */
    public function address_country_defaults_to_philippines(): void
    {
        $address = Address::create([
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Davao City',
            'province' => 'Davao del Sur',
        ]);

        $this->assertEquals('Philippines', $address->country);
    }

    /** @test */
    public function address_can_be_used_as_current_address(): void
    {
        $address = Address::create([
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Davao City',
            'province' => 'Davao del Sur',
            'country' => 'Philippines',
        ]);

        $student = \App\Models\Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $this->assertEquals($address->address_id, $student->current_address_id);
    }

    /** @test */
    public function address_can_be_used_as_permanent_address(): void
    {
        $address = Address::create([
            'barangay' => 'Test Barangay',
            'municipality_city' => 'Davao City',
            'province' => 'Davao del Sur',
            'country' => 'Philippines',
        ]);

        $student = \App\Models\Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
        ]);

        $this->assertEquals($address->address_id, $student->permanent_address_id);
    }

    /** @test */
    public function student_can_have_different_current_and_permanent_addresses(): void
    {
        $currentAddress = Address::create([
            'barangay' => 'Current Barangay',
            'municipality_city' => 'Davao City',
            'province' => 'Davao del Sur',
            'country' => 'Philippines',
        ]);

        $permanentAddress = Address::create([
            'barangay' => 'Permanent Barangay',
            'municipality_city' => 'Manila',
            'province' => 'Metro Manila',
            'country' => 'Philippines',
        ]);

        $student = \App\Models\Student::create([
            'lrn' => '123456789012',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Male',
            'current_address_id' => $currentAddress->address_id,
            'permanent_address_id' => $permanentAddress->address_id,
        ]);

        $this->assertNotEquals($student->current_address_id, $student->permanent_address_id);
    }
}