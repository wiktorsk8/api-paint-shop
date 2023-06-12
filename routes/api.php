<?php

use App\Http\Controllers\Api\User\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
    Route::apiResource('products', \App\Http\Controllers\Api\Admin\ProductController::class);
    Route::apiResource('orders', \App\Http\Controllers\Api\Admin\OrderController::class);
});

//Route::post('/test', [\App\Http\Controllers\Api\User\Auth\elo::class, 'test']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


