<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->randomId(Product::class),
            'customer_address_id' => $this->randomId(Address::class),
            'customer_id' => $this->randomId(User::class),
        ];
    }

    private function randomId(string $modelClass): int{
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new \InvalidArgumentException('Invalid model class provided.');
        }

        $model = new $modelClass;

        $ids = $model->select('id')
            ->limit(10)
            ->pluck('id')
            ->toArray();

        return $this->faker->randomElement($ids);
    }



}
