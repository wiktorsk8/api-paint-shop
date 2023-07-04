<?php

use App\Http\Controllers\Api\User\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/test', function (){
    dump(\Illuminate\Support\Facades\Auth::check());
    return 0;
});


// Authentication
Route::middleware('check.auth.api')->group(function (){
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('/logout',[AuthController::class, 'logout']);
});


// Products
Route::controller(ProductController::class)->group(function (){
    Route::get('/products', 'index');
    Route::get('/products/{product}', 'show');
    Route::middleware(['auth:sanctum'])->group(function (){
        Route::post('/products', 'store');
        Route::put('/products/{product}', 'update');
        Route::delete('/products/{product}', 'destroy');
    });
});


// Orders
Route::controller(OrderController::class)->group(function (){
    Route::post('/orders', 'store');
    Route::get('/orders/tracking', 'trackingGuest');

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::get('/orders', 'index');
        Route::get('/orders/{order}', 'show');
        Route::put('/orders/{order}', 'update');
        Route::delete('/orders/{order}', 'destroy');
        Route::get('/orders/tracking/{order}', 'tracking');
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


