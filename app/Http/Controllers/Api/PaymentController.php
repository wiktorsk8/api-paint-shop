<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentsService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentsService $paymentService
    )
    {}

    public function checkout(Request $request){

        $clientSecret = $this->paymentService->process(
            $request->payment_intent_id,
            $request->cart_id,
            $request->product_ids
        );
        
        return response()->json($clientSecret, 201);
    }
}
