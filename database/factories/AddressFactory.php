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
            'street' => fake()->streetName(),
            'postal_code' => fake()->postcode(),
            'building_number' => fake()->streetName(),
            'country_code' => fake()->countryCode(),
            'extra_info' => fake()->text(100),
        ];
    }
}
