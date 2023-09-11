<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function create(){
        $cart = Cart::create();

        return response()->json([
            'cartId' => $cart->id
        ]);
    }
}
