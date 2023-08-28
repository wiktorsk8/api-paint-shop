<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentsService
{

    protected StripeClient $stripe;

    public function create(array $productIds)
    {
        // TEST MODE ON

        $this->stripe = new StripeClient(config('services.stripe.secret-test'));

        try {
            $products = $this->fetchProducts($productIds);

            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $this->calculateOrderAmount($products),
                'currency' => 'pln',
                // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                'payment_method' => 'pm_card_visa'
            ]);

            return ['clientSecret' => $paymentIntent->client_secret];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function calculateOrderAmount(array $products)
    {
        $totalAmount = 0;
        foreach ($products as $product) {
            $totalAmount += $product->base_price;
        }

        return $totalAmount*100;
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
