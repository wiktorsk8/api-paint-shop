<?php

namespace App\Services;

use App\DTO\AddressDTO;
use App\Models\OrderedProduct;
use App\Models\Order;
use App\Models\Product;
use App\DTO\OrderDTO;
use App\DTO\UserDetailsDTO;
use App\Enums\OrderStateEnum;
use App\Http\Requests\Order\UpdateOrderRequest;
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

        $order = $this->storeOrder();
        $this->storeOrderedProducts($this->orderDTO->getProductIds(), $order->id);

        return $order;
    }

    private function storeOrder(): Order {
        $order = new Order();
        $order->order_details_id = $this->storeOrderDetails($this->orderDTO->getUserDTO(), $this->orderDTO->getAddressDTO())->id;
        $order->user_id = Auth::guard('api')->check() ? Auth::guard('api')->id() : null;
        $order->state = OrderStateEnum::NotPaid; 
        $order->payment_method = $this->orderDTO->getPaymentMethod();
        $order->delivery_method = $this->orderDTO->getDeliveryMethod();
        $order->payment_intent_id = $this->orderDTO->getPaymentIntentId();
        $order->save();

        return $order;
    }

    private function storeOrderDetails(UserDetailsDTO $userDTO, AddressDTO $addressDTO): OrderDetails
    {
        return OrderDetails::create([
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
    }

    private function storeOrderedProducts(array $productIds, $orderId): void
    {
        foreach ($productIds as $productId){
            OrderedProduct::create([
                'order_id' => $orderId,
                'product_id' => $productId
            ]);
        }
    }
}
