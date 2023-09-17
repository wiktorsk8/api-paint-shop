<?php

namespace App\Jobs;

use App\Enums\OrderStateEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrderState implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private string $paymentIntentId;

    public function __construct(string $paymentIntentId)
    {
        $this->paymentIntentId = $paymentIntentId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::where('payment_intent_id', '=', $this->paymentIntentId)->first();
        $order->state = OrderStateEnum::Paid;
        $order->save();
    }
}
