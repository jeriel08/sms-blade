<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $address = Address::factory()->create();

        return [
            'lrn' => $this->faker->unique()->numerify('############'),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'extension_name' => null,
            'birthdate' => $this->faker->date('Y-m-d', '-12 years'),
            'place_of_birth' => $this->faker->city(),
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'mother_tounge' => $this->faker->randomElement(['Tagalog', 'Cebuano', 'Ilocano', 'Hiligaynon']),
            'psa_birth_cert_no' => $this->faker->optional()->numerify('PSA-##########'),
            'is_ip' => false,
            'ip_community' => null,
            'current_address_id' => $address->address_id,
            'permanent_address_id' => $address->address_id,
            'is_disabled' => false,
        ];
    }

    public function withDisability(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_disabled' => true,
        ]);
    }

    public function indigenousPeople(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_ip' => true,
            'ip_community' => $this->faker->randomElement(['Bagobo', 'Manobo', 'Mandaya', 'Ata']),
        ]);
    }
}