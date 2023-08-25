<?php 

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentsService{

    protected StripeClient $stripe;

    public function create(Request $request){
        $this->stripe = new StripeClient(config('services.stripe.secret'));
        $products = $this->fetchProducts($request->product_ids);

        
    }

    public function callculateOrderDetails(){

    }

    private function fetchProducts(array $products): array{
        $result = [];
        foreach($products as $id){
            $product = Product::where('id', '=', $id)->first();
            array_push($request, $product);
        }

        return $result;
    }
}