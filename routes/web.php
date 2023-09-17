<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\PendingOrderData;
use Illuminate\Support\Facades\Auth;


Route::get('/cipa', function(){
    $user = Auth::user() ?: throw new Exception("User not authenticated");
});

