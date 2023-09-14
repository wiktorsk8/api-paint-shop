<?php

namespace App\Jobs;

use App\DTO\AddressDTO;
use App\DTO\OrderDTO;
use App\DTO\UserDetailsDTO;
use App\DTO\UserInfoDTO;
use App\Models\PendingOrderData;
use App\Models\UserDetails;
use App\Services\OrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderPlacementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $pendingOrder = PendingOrderData::where('payment_intent_id', '=', $this->paymentIntentId)->first();
        

        $data = $pendingOrder->data;

        $addressDTO = new AddressDTO(
            $data['userData']['address']['street'],
            $data['userData']['address']['buildingNumber'],
            $data['userData']['address']['city'],
            $data['userData']['address']['postalCode'],
            $data['userData']['address']['countryCode'],
            $data['userData']['address']['extraInfo'],
        );

        $userDTO = new UserDetailsDTO(
            $data['userData']['credentials']['firstName'],
            $data['userData']['credentials']['lastName'],
            $data['userData']['credentials']['email'],
            $data['userData']['credentials']['phone'],
            $data['userData']['companyInfo']['companyName'],
            $data['userData']['companyInfo']['NIP'],
        );

        $orderService = new OrderService();
        $orderService->store(new OrderDTO(
            $userDTO,
            $addressDTO,
            $data['userData']['paymentMethod'],
            $data['userData']['deliveryMethod'],
            [$data['userData']['productId']]
        ));
    }
}
