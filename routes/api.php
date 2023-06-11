<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController as HomeProductController;
use App\Http\Controllers\Api\User\CategoryController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('.user');

    Route::name('.orders')->group(function () {
        Route::post('/orders', [OrderController::class, 'store'])->name('.store');
        Route::get('/orders', [OrderController::class, 'getOrders'])->name('.getOrders');
    });

    Route::name('.product')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('.index');
        Route::patch('/products/toggle-status', [ProductController::class, 'toggleStatus'])->name('.toggleStatus');
        Route::get('/productscustomer', [HomeController::class, 'index'])->name('.home');
    });
});

Route::name('.categories')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::patch('/categories/toggle-status', [CategoryController::class, 'toggleStatus'])->name('.toggleStatus');
});

Route::name('.customers')->group(function () {
    Route::get('/customers', [UserController::class, 'index']);
    Route::patch('/customers/toggle-status', [UserController::class, 'toggleStatus'])->name('.toggleStatus');
});

Route::post('/products/quantity', [HomeProductController::class, 'validQuantityProduct'])->name('.valquantity');
Route::post('/products/cart', [HomeProductController::class, 'getCartProducts'])->name('.getCartProducts');
