<?php

namespace Database\Factories;

use App\Models\Order;
use App\Traits\ReturnsRandomId;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderedProduct>
 */
class OrderedProductFactory extends Factory
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
            'order_id' => $this->randomId(Order::class, 'uuid'),
            'product_id' => $this->randomId(Product::class),
        ];
    }
}
