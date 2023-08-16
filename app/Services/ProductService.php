<?php 

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function applyDiscountPrecentage(Product $product, $discount){
        $product->discount = $discount;
        $product->update(['discount' => $discount]);
    }

    public function deleteDiscount(Product $product){
        $product->update(['discount' => 0]);
    }
}