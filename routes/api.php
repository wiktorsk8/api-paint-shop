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

Route::middleware('check.auth.api')->group(function (){
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});



Route::get('/products',[ProductController::class, 'index']);
Route::get('/products/{product}',[ProductController::class, 'show']);


Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('/logout',[AuthController::class, 'logout']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    Route::apiResource('orders', OrderController::class);
    Route::get('orders/tracking/{order}', [OrderController::class, 'tracking']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


