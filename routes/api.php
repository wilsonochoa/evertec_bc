<?php

use App\Http\Controllers\Api\HomeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('.categories')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::patch('/categories/toggle-status', [CategoryController::class, 'toggleStatus'])->name('.toggleStatus');
});

Route::name('.product')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::patch('/products/toggle-status', [ProductController::class, 'toggleStatus'])->name('.toggleStatus');
    Route::get('/productscustomer', [HomeController::class, 'index'])->name('.home');
});

Route::name('.customers')->group(function () {
    Route::get('/customers', [UserController::class, 'index']);
    Route::patch('/customers/toggle-status', [UserController::class, 'toggleStatus'])->name('.toggleStatus');
});
