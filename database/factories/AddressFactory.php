<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data' => [
                'city' => fake()->city(),
                'postal_code' => fake()->postcode(),
                'street_name' => fake()->streetName(),
                'street_number' => fake()->numberBetween(1, 100),
                'flat_number' => fake()->numberBetween(1, 1000)
            ]
        ];
    }
}
