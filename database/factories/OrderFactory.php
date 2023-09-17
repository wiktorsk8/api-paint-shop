<?php

namespace Database\Factories;

use App\Enums\OrderStateEnum;
use App\Models\OrderDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'order_details_id' => OrderDetails::factory()->create()->id,
            'user_id' => $this->randomId(User::class),
            'state' => OrderStateEnum::randomValue(),
            'payment_method' => "visa/twojastara/bitkojn",
            'payment_intent_id' => "id_intenta_12312423dfshfsdk",
            'delivery_method' => "Inpost"
        ];
    }

    



}
