<?php

namespace Database\Factories\Order;

use App\Models\Order\Address;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ReturnsRandomId;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order\Order>
 */
class OrderFactory extends Factory
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
            'product_id' => $this->randomId(Product::class),
            'details' => $this->randomId(Address::class),
            'user_id' => $this->randomId(User::class),
        ];
    }

    



}
