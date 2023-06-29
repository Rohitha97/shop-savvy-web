<?php

use App\Http\Controllers\API\APIUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::post('/login', [APIUserController::class, 'login']);
    Route::post('/register', [APIUserController::class, 'register']);
});

Route::prefix('/products')->group(function () {
    Route::GET('/get', [ProductsController::class, 'get']);
});

Route::prefix('/cart')->group(function () {
    Route::GET('/add', [CartController::class, 'addToCart']);
    Route::GET('/products/get', [CartController::class, 'getProducts']);
    Route::GET('/products/paid', [CartController::class, 'getPaidProducts']); //send cart id as id
    Route::GET('/products/remove', [CartController::class, 'removeCartProduct']);
    Route::GET('/products/suggetions', [CartController::class, 'getSuggetions']);
    Route::GET('/payment/done', [CartController::class, 'paymentDone']);
    Route::GET('/payment/verify', [CartController::class, 'verifyPayment']); //send cart id as id
    Route::GET('/history/get', [CartController::class, 'historyGet']);
});

Route::GET('/stock/check/{rfid}', [ProductsController::class, 'checkStock']);
