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
    Route::get('/lstuser', [UserController::class, 'index'])->middleware('can:admin.home')->name('admin.home');

    Route::get('/updateuser/{user}', [UserController::class, 'updateUser'])
        ->name('admin.update');

    Route::patch('/toggleuserstatus', [UserController::class, 'toggleStatus'])
        ->middleware('can:admin.update')->name('admin.toggleUserStatus');

    Route::put('/updateuserprocess/{user}', [UserController::class, 'updateUserProcess'])
        ->middleware('can:admin.update')->name('admin.updateProcess');

    //Category
    Route::get('/lstcategory', [CategoryController::class, 'index'])->middleware('can:admin.home')
    ->name('category.home');

    Route::get('/createcategory', [CategoryController::class, 'create'])->middleware('can:admin.home')
    ->name('category.create');

    Route::post('/categorystore', [CategoryController::class, 'store'])->middleware('can:admin.home')
    ->name('category.store');

    Route::get('/categorystore/{category}', [CategoryController::class, 'edit'])->middleware('can:admin.home')
    ->name('category.edit');

    Route::put('/categoryupdate/{category}', [CategoryController::class, 'update'])
    ->middleware('can:admin.update')->name('category.update');

    //Products

    Route::get('/lstproducts', [ProductController::class, 'index'])->middleware('can:admin.home')
    ->name('product.home');

    Route::get('/createproduct', [ProductController::class, 'create'])->middleware('can:admin.home')
    ->name('product.create');

    Route::post('/productstore', [ProductController::class, 'store'])->middleware('can:admin.home')
    ->name('product.store');

    Route::get('/editproduct/{product}', [ProductController::class, 'edit'])->middleware('can:admin.home')
    ->name('product.edit');

    Route::patch('/productupdate/{product}', [ProductController::class, 'update'])->middleware('can:admin.home')
    ->name('product.update');

    Route::get('/products/detail/{slug}', [HomeProduct::class, 'show'])->middleware('can:customer.orders')
        ->name('product-detail');

    Route::get('/cart', [CartController::class, 'index'])->name('cart')->middleware('can:customer.orders');

    Route::resource('orders', OrderController::class)->middleware('can:customer.orders')->only('show');

    Route::get('/orders', [OrderController::class, 'index'])->middleware('can:customer.orders')
        ->name('order.index');
});
