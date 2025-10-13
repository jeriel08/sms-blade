<?php

namespace Tests\Unit;

use App\Models\Disability;
use App\Models\Student;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisabilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function disability_can_be_created(): void
    {
        $disability = Disability::create([
            'name' => 'Visual Impairment',
        ]);

        $this->assertDatabaseHas('disabilities', [
            'name' => 'Visual Impairment',
        ]);
    }

    /** @test */
    public function disability_name_must_be_unique(): void
    {
        Disability::create(['name' => 'Visual Impairment']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Disability::create(['name' => 'Visual Impairment']);
    }

    /** @test */
    public function disability_has_many_students(): void
    {
        $disability = Disability::create(['name' => 'Visual Impairment']);

        $address = Address::create([
            'barangay' => 'Test',
            'municipality_city' => 'City',
            'province' => 'Province',
            'country' => 'Philippines',
        ]);

        $student1 = Student::create([
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

        $student2 = Student::create([
            'lrn' => '123456789013',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'birthdate' => '2010-01-01',
            'place_of_birth' => 'City',
            'sex' => 'Female',
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
            'is_disabled' => 1,
        ]);

        $disability->students()->attach([$student1->student_id, $student2->student_id]);

        $this->assertCount(2, $disability->students);
    }

    /** @test */
    public function student_can_have_multiple_disabilities(): void
    {
        $disability1 = Disability::create(['name' => 'Visual Impairment']);
        $disability2 = Disability::create(['name' => 'Hearing Impairment']);

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

        $student->disabilities()->attach([$disability1->disability_id, $disability2->disability_id]);

        $this->assertCount(2, $student->disabilities);
    }

    /** @test */
    public function disability_can_be_detached_from_student(): void
    {
        $disability = Disability::create(['name' => 'Visual Impairment']);

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

        $student->disabilities()->attach($disability->disability_id);
        $this->assertCount(1, $student->disabilities);

        $student->disabilities()->detach($disability->disability_id);
        $this->assertCount(0, $student->fresh()->disabilities);
    }

    /** @test */
    public function multiple_disabilities_can_exist(): void
    {
        Disability::create(['name' => 'Visual Impairment']);
        Disability::create(['name' => 'Hearing Impairment']);
        Disability::create(['name' => 'Physical Disability']);
        Disability::create(['name' => 'Learning Disability']);

        $this->assertEquals(4, Disability::count());
    }
}