<?php

namespace App\Services;

use App\DTO\OrderDTO;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use Exception;

class OrderService
{
    public function store(OrderDTO $dto): Order{
        $product = Product::findOrFail($dto->getProductId());

        if (!$product->in_stock) throw new Exception('product not in stock');

        $address = Address::create([
            'data' => [
                'city' => $dto->getCity(),
                'postal_code' => $dto->getPostalCode(),
                'street_name' => $dto->getStreetName(),
                'street_number' => $dto->getStreetNumber(),
                'flat_number' => $dto->getFlatNumber()
            ]
        ]);

        $order = Order::create([
            'product_id' => $dto->getProductId(),
            'customer_address_id' => $address->id,
            'customer_id' => $dto->getCustomerId()
        ]);

        return $order;
    }
}
