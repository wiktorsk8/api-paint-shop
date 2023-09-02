<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Auth;

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

// Authentication
Route::middleware('check.auth.api')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/check-auth', [AuthController::class, 'checkAuth']);

// Products
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{product}', 'show');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/products', 'store');
        Route::put('/products/{product}', 'update');
        Route::delete('/products/{product}', 'destroy');
    });
});

// Orders
Route::controller(OrderController::class)->group(function () {
    Route::post('/orders', 'store');
    Route::get('/orders/tracking', 'trackingGuest');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/orders', 'index');
        Route::get('/orders/{order}', 'show');
        Route::put('/orders/{order}', 'update');
        Route::delete('/orders/{order}', 'destroy');
        Route::get('/orders/tracking/{id}', 'tracking');
    });
});

// User
Route::controller(UserController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{user}', 'show');
        Route::put('/users/{user}', 'update');
        Route::delete('/users/{user}', 'destroy');
        Route::post('/users/save-shipping-info/{user}', 'saveShippingInfo');
    });
});

// Address
Route::controller(AddressController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/addresses/{address}', 'view');
        Route::post('/addresses', 'store');
    });
});

// Payment
Route::controller(PaymentController::class)->group(function () {
});

// Cart
Route::get('/create-cart', function () {
    return response()->json(["cart_id" => uniqid("cart_id", true)], 200);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
