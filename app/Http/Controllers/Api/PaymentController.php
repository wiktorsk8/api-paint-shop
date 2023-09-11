<?php

namespace App\Http\Controllers\Api;

use App\Events\PaymentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentIntentRequest;
use App\Services\PaymentsService;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function __construct(
        protected PaymentsService $paymentService
    )
    {}

    public function process(PaymentIntentRequest $request){

        $clientSecret = $this->paymentService->process(
            $request->payment_intent_id,
            $request->cart_id,
            $request->product_id
        );

        return response()->json($clientSecret, 201);
    }
}
