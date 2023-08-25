<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentsService;
use Illuminate\Http\Request;
use Stripe;
use Stripe\StripeClient;

class PaymentsController extends Controller
{

    public function __construct(
        protected PaymentsService $paymentsService
    )
    {}

    public function process(Request $request){
        $this->paymentsService->create($request);
    }
}
