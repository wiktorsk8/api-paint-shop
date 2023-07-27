<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Traits\ReturnsRandomId;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order\Address>
 */
class AddressFactory extends Factory
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
            'city' => fake()->city(),
            'user_id' => $this->randomId(User::class),
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
