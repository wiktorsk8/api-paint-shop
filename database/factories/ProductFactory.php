<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $basePrice = fake()->randomFloat(2, 0, 99999);
        $discount = fake()->numberBetween(0, 99);
        $discountedPrice = $basePrice * (1 - $discount/100);
        return [
            'name' => fake()->name(),
            'base_price' => $basePrice,
            'description' => fake()->text(150),
            'image' => fake()->image(),
            'in_stock' => true,
            'discount' => $discount,
            'discounted_price' => $discountedPrice
        ];
    }
}
