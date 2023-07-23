<?php

namespace App\Services;

use App\Models\OrderedProduct;
use App\Models\Order\Order;
use App\Models\Product;
use App\DTO\OrderDTO;

use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function store(OrderDTO $dto): Order
    {
        foreach ($dto->getProductId() as $id) {
            $product = Product::findOrFail($id);

            if (!$product->in_stock) throw new \Exception('Product not in stock!');
        }

        $order = new Order();
        $order->details = $this->fillDetails($dto);
        $order->user_id = Auth::guard('api')->check() ? Auth::guard('api')->id() : null;
        $order->is_paid = true; 
        $order->save();

        $this->storeOrderedProducts($dto->getProductId(), $order->id);

        return $order;
    }


    private function fillDetails(OrderDTO $dto)
    {
        $details = [
            'first_name' => $dto->getFirstName(),
            'last_name' => $dto->getLastName(),
            'phone' => $dto->getPhone(),
            'city' => $dto->getCity(),
            'postal_code' => $dto->getPostalCode(),
            'street_name' => $dto->getStreetName(),
            'street_number' => $dto->getStreetNumber(),
            'flat_number' => $dto->getFlatNumber(),
            'company_name' => $dto->getCompanyName(),
            'NIP' => $dto->getNIP(),
            'extra_info' => $dto->getExtraInfo(),
        ];

        return json_encode($details);
    }

    private function storeOrderedProducts(array $productIds, $orderId){
        foreach ($productIds as $productId){
            OrderedProduct::create([
                'order_id' => $orderId,
                'product_id' => $productId
            ]);
        }
    }
}
