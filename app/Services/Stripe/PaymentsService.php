<?php

namespace App\Services\Stripe;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Log;

class PaymentsService
{
    private StripeClient $stripe;


    public function process($paymentIntentId, array $productIds): array
    {
        // TEST MODE ON
        $this->stripe = new StripeClient(config('services.stripe.secret-test'));
        

        $products = $this->fetchProducts($productIds);

        if ($paymentIntentId == null) {
            $intent = $this->createIntent($this->calculateAmount($products));

            return [
                'clientSecret' => $intent->client_secret,
                'paymentIntentId' => $intent->id
            ];
        }

        $intent = $this->updateIntent($paymentIntentId, $this->calculateAmount($products));

        return [
            'clientSecret' => $intent->client_secret,
        ];
    }

    private function createIntent(int $amount)
    {
        try {
            $paymentIntent = $this->stripe->paymentIntents->create(
                [
                    'amount' => $amount,
                    'currency' => 'pln',
                    // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                    'payment_method' => 'pm_card_visa',
                    
                ]
            );

            return $paymentIntent;
        } catch (Exception $e) {
            throw new Exception("Something went wrong with creating an intent. ". $e->getMessage());
        }
    }

    private function updateIntent(string $intentId, $amount)
    {
        try {
            $this->stripe->paymentIntents->update(
                $intentId,
                ['amount' => $amount]
            );

            return $this->stripe->paymentIntents->retrieve($intentId);
        } catch (Exception) {
            throw new Exception("Something went wrong in updateIntent() method");
        }
    }

    private function calculateAmount(array $products): int
    {
        $totalAmount = 0;
        foreach ($products as $product) {
            $totalAmount += $product->base_price;
        }

        return $totalAmount * 100;
    }

    private function fetchProducts(array $products): array
    {
        $result = [];
        foreach ($products as $id) {
            $product = Product::where('id', '=', $id)->first();
            if (!$product->in_stock) {
                throw new Exception("Product id:{$product->id} is not in stock!");
            }
            array_push($result, $product);
        }

        return $result;
    }
}
