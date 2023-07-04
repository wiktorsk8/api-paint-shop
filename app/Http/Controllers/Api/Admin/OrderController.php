<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTO\OrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\GuestOrderResource;
use App\Http\Resources\OrderResource;
use App\Models\Order\Order;
use App\Services\OrderService;
use PHPUnit\Framework\Exception;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
        $this->authorizeResource(Order::class, 'order');
    }

    public function index(){
        return response()->json(Order::all());
    }

    public function store(StoreOrderRequest $request){
        $orderData = new OrderDTO(
            $request->name,
            $request->email,
            $request->phone,
            $request->product_id,
            $request->city,
            $request->postal_code,
            $request->street_name,
            $request->street_number,
            $request->flat_number
        );

        $order = $this->orderService->store($orderData);

        return new OrderResource($order);
    }


    public function show(Order $order){
        return response()->json($order);
    }

    public function update(UpdateOrderRequest $request){
        throw new Exception('Checkout not made yet');
    }

    public function destroy(Order $order){
        $order->delete();

        return response()->json(['message' => 'Product deleted succesfully'], 200);
    }

    public function tracking(Order $order){
        $this->authorize('tracking', $order);

        return new OrderResource($order);
    }

    public function trackingGuest(Order $order){
        return new GuestOrderResource($order);
    }
}
