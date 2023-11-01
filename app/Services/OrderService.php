<?php

namespace App\Services;

use App\DTO\AddressDTO;
use App\Models\OrderedProduct;
use App\Models\Order;
use App\Models\Product;
use App\DTO\OrderDTO;
use App\DTO\UserDetailsDTO;
use App\Enums\OrderStateEnum;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    private OrderDTO $orderDTO;

    public function store(OrderDTO $orderDTO): Order
    {
        foreach ($orderDTO->getProductIds() as $id) {
            $product = Product::findOrFail($id);

            if (!$product->in_stock) throw new \Exception('Product not in stock!');
        }

        $this->orderDTO = $orderDTO;

        $order = $this->startTransaction();
       // $this->storeOrderedProducts($this->orderDTO->getProductIds(), $order->id);

        return $order;
    }

    private function startTransaction(AddressDTO $addressDTO, UserDetailsDTO $userDTO, $productIds){
        DB::beginTransaction();

        try {
            $orderDetailsId = DB::table('order_details')->insertGetId([
                'street' => $addressDTO->getStreet(),
                'building_number' => $addressDTO->getBuildingNumber(),
                'city' => $addressDTO->getCity(),
                'postal_code' => $addressDTO->getPostalCode(),

                'first_name' => $userDTO->getFirstName(),
                'last_name' => $userDTO->getLastName(),
                'phone' => $userDTO->getPhone(),
                'email' => $userDTO->getEmail(),

                'company_name' => $userDTO->getCompanyName(),
                'NIP' => $userDTO->getNIP(),
                'extra_info' => $addressDTO->getExtraInfo(),
            ]);

            $order_id = DB::table('orders')->insertGetId([
                'order_details_id' => $orderDetailsId,
                'user_id' => Auth::guard('api')->check() ? Auth::guard('api')->id() : null,
                'state' => OrderStateEnum::NotPaid,
                'payment_method' => $this->orderDTO->getPaymentMethod(),
                'delivery_method' => $this->orderDTO->getDeliveryMethod(),
                'payment_intent_id' => $this->orderDTO->getPaymentIntentId(),
            ]);

            foreach ($productIds as $id){
                DB::table('ordered_products')->insert([
                    'order_id' => $order_id,
                    'product_id' => $id
                ]);
            }

            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
        }
    }
}
