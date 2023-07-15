<?php

use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ProductController as HomeProduct;
use App\Http\Controllers\Web\User\CategoryController;
use App\Http\Controllers\Web\User\ProductController;
use App\Http\Controllers\Web\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->middleware('can:admin.home')->name('admin.home');

    Route::get('/update/user/{user}', [UserController::class, 'updateUser'])
        ->name('admin.update');

    Route::patch('/toggle-status', [UserController::class, 'toggleStatus'])
        ->middleware('can:admin.update')->name('admin.toggleUserStatus');

    Route::put('/update/user/{user}', [UserController::class, 'updateUserProcess'])
        ->middleware('can:admin.update')->name('admin.updateProcess');

    //Category
    Route::resource('categories', CategoryController::class)
        ->middleware('can:admin.categories')->except(['destroy']);

    //Products

    Route::resource('products', ProductController::class)
        ->middleware('can:admin.products')->except(['destroy']);

    Route::get('/products/detail/{slug}', [HomeProduct::class, 'show'])->middleware('can:customer.orders')
        ->name('product-detail');

    Route::get('/cart', [CartController::class, 'index'])->name('cart')->middleware('can:customer.orders');

    Route::resource('orders', OrderController::class)->middleware('can:customer.orders')->only('show');

    Route::get('/orders', [OrderController::class, 'index'])->middleware('can:customer.orders')
        ->name('order.index');
});
