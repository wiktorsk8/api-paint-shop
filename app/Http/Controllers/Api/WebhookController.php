<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class WebhookController extends Controller
{
    public function trigger(Request $request)
    {
        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(), 
                $request->header("Stripe-Signature"), 
                "whsec_8836139a5d18a43d9a12b4696de32dab1894b7a866070b5100f82f6a0ac1244d"
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json([
                'Error parsing payload: ' => $e->getMessage()
            ],400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json([
                'Error verifying webhook signature: ' => $e->getMessage()]
                ,400);
        }


        return response()->json($request, 200);
    }
}
