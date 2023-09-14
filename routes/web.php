<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\PendingOrderData;

Route::get('/cipa', function(){
    $pendingOrder = PendingOrderData::where('payment_intent_id', '=', 'pi_3NqIQqIZDMPwornj1QXcqrvz')->first();
    $data = $pendingOrder->data;
    dd($data['userData']);
});