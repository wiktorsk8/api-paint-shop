<?php

namespace App\Http\Controllers\Api;

use App\DTO\AddressDTO;
use App\DTO\OrderDTO;
use App\DTO\UserDetailsDTO;
use App\DTO\UserInfoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\SavePendingOrderData;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\PendingOrderData;
use App\Services\OrderService;
use App\Services\UserService;
use Exception;
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
        $collection = collect($request->validated());
        
        $userDTO = new UserDetailsDTO(
            $collection->get('userData.credentials.firstName'),
            $collection->get('userData.credentials.lastName'),
            $collection->get('userData.credentials.email'),
            $collection->get('userData.credentials.phone'),
            $collection->get('userData.companyInfo.companyName'),
            $collection->get('userData.companyInfo.NIP'),
        );

        $addressDTO = new AddressDTO(
            $collection->get('userData.address.city'),
            $collection->get('userData.address.postalCode'),
            $collection->get('userData.address.street'),
            $collection->get('userData.address.buildingNumber'),
            $collection->get('userData.address.countryCode'),
            $collection->get('userData.address.extraInfo'),
        );

        $orderDTO = new OrderDTO(
            $userDTO, 
            $addressDTO,
            $collection->get('paymentMethod'),
            $collection->get('deliveryMethod'),
            $collection->get('productId'),
            $collection->get('paymentIntentId')
        );

        try{
            $order = $this->orderService->store($orderDTO);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
        

        if ($collection->get('save')){
            $userService = new UserService();
            $userService->saveData($userDTO, $addressDTO);
        }

        return response()->json([
            'message' => "Order has been created. ID: {$order->id}"
        ], 201);
    }   


    public function show(Order $order)
    {
        return new OrderResource($order);
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
}
