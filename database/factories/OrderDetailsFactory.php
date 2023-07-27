<?php

namespace Database\Factories;

use App\Traits\ReturnsRandomId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetails>
 */
class OrderDetailsFactory extends Factory
{

    use ReturnsRandomId;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->numberBetween(100000000, 200000000),
            'city' => fake()->city(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'street_name' => fake()->streetName(),
            'street_number' => fake()->numberBetween(1, 100),
            'flat_number' => fake()->numberBetween(1, 1000),
            'company_name' => fake()->company(),
            'NIP' => fake()->numberBetween(10000000000, 200000000),
            'extra_info' => fake()->text(100),
        ];
    }
}
