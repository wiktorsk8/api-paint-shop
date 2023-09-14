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
    public function store(OrderDTO $orderDTO): Order
    {
        foreach ($orderDTO->getProductIds() as $id) {
            $product = Product::findOrFail($id);

            if (!$product->in_stock) throw new \Exception('Product not in stock!');
        }

        $order = new Order();
        $order->order_details_id = $this->createDetails($orderDTO->getUserDTO(), $orderDTO->getAddressDTO())->id;
        $order->user_id = Auth::guard('api')->check() ? Auth::guard('api')->id() : null;
        $order->state = OrderStateEnum::Placed; 
        $order->payment_method = $orderDTO->getPaymentMethod();
        $order->delivery_method = $orderDTO->getDeliveryMethod();
        $order->save();

        $this->storeOrderedProducts($orderDTO->getProductIds(), $order->id);

        return $order;
    }

    public function update(UpdateOrderRequest $request, Order $order): Order
    {
        $orderDetails = OrderDetails::where('id', '=', $order->order_details_id);
        $orderDetails->update($request->validated());

        return $order;
    }

    private function createDetails(UserDetailsDTO $userDTO, AddressDTO $addressDTO): OrderDetails
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

    private function storeOrderedProducts(array $productIds, $orderId)
    {
        foreach ($productIds as $productId){
            OrderedProduct::create([
                'order_id' => $orderId,
                'product_id' => $productId
            ]);
        }
    }
}
