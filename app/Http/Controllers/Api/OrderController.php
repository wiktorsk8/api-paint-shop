<?php

namespace App\Http\Controllers\Api;

use App\DTO\UserInfoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\SavePendingOrderData;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\PendingOrderData;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;

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
        return Order::all();
    }

    public function store(StoreOrderRequest $request)
    {
        
    }   


    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $updatedOrder = $this->orderService->update($request, $order);

        return new OrderResource($updatedOrder);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(['message' => 'Order deleted succesfully'], 200);
    }

    public function tracking($id)
    {
        $orders = Order::where('user_id', '=', $id)->get();

        return OrderResource::collection($orders);
    }

    public function trackingGuest(Order $order)
    {
        $this->authorize('trackingGuest', $order);

        return new OrderResource($order);
    }

    public function savePendingOrderData(SavePendingOrderData $request){
        $id = $request->paymentIntentId;
        $data = array_filter($request->validated(),function($key){
            return $key !== 'payment_intent_id';
        }, ARRAY_FILTER_USE_KEY);

        PendingOrderData::create([
            'payment_intent_id' => $id,
            'data' => $data
        ]);
    }
}
