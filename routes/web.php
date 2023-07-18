<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('root');;
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', [UserController::class, 'logout'])->name('admin.logout');


Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->middleware(['auth', 'permitted'])->name('admin.users');
    Route::post('/add', [UserController::class, 'add'])->name('admin.users.add')->middleware(['auth']);
    Route::get('/get', [UserController::class, 'getOne'])->name('admin.users.get.one')->middleware(['auth']);
    Route::get('/delete', [UserController::class, 'deleteOne'])->name('admin.users.delete.one')->middleware(['auth']);
    Route::get('/find', [UserController::class, 'find'])->name('admin.users.find.one')->middleware(['auth']);
});

Route::prefix('/usertypes')->group(function () {
    Route::get('/', [UserTypeController::class, 'index'])->middleware(['auth', 'permitted'])->name('admin.usertypes');
    Route::post('/add', [UserTypeController::class, 'add'])->name('admin.usertypes.add')->middleware(['auth']);
    Route::get('/get', [UserTypeController::class, 'getOne'])->name('admin.usertypes.get.one')->middleware(['auth']);
    Route::get('/delete', [UserTypeController::class, 'deleteOne'])->name('admin.usertypes.delete.one')->middleware(['auth']);
});

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->middleware(['auth', 'permitted'])->name('admin.products');
    Route::post('/add', [ProductsController::class, 'add'])->name('admin.products.add')->middleware(['auth']);
    Route::get('/get', [ProductsController::class, 'getOne'])->name('admin.products.get.one')->middleware(['auth']);
    Route::get('/delete', [ProductsController::class, 'deleteOne'])->name('admin.products.delete.one')->middleware(['auth']);
});

Route::prefix('/stocks')->group(function () {
    Route::get('/', [StockController::class, 'index'])->middleware(['auth', 'permitted'])->name('admin.stocks');
    Route::post('/add', [StockController::class, 'add'])->name('admin.stocks.add')->middleware(['auth']);
    Route::get('/get', [StockController::class, 'getOne'])->name('admin.stocks.get.one')->middleware(['auth']);
    Route::get('/delete', [StockController::class, 'deleteOne'])->name('admin.stocks.delete.one')->middleware(['auth']);
});

Route::prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->middleware(['auth', 'permitted'])->name('admin.orders');
    Route::get('/view', [OrderController::class, 'view'])->name('admin.orders.view')->middleware(['auth']);
});
