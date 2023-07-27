<?php

namespace App\Http\Controllers\Api;

use App\DTO\OrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use PHPUnit\Framework\Exception;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        return response()->json(Order::all());
    }

    public function store(StoreOrderRequest $request)
    {
        $orderData = new OrderDTO(
            $request->product_id,
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->phone,
            $request->city,
            $request->postal_code,
            $request->street_name,
            $request->street_number,
            $request->flat_number,
            $request->company_name,
            $request->NIP,
            $request->extra_info,
        );

        $order = $this->orderService->store($orderData);

        return new OrderResource($order);
    }


    public function show(Order $order)
    {
        return response()->json($order);
    }

    public function update(UpdateOrderRequest $request)
    {
        //
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(['message' => 'Order deleted succesfully'], 200);
    }

    public function tracking(Order $order)
    {
        $this->authorize('tracking', $order);

        return new OrderResource($order);
    }

    public function trackingGuest(Order $order)
    {
        return new OrderResource($order);
    }
}
