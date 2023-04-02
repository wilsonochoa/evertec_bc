<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

use Inertia\Inertia;

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

    Route::get('/lstuser', [AdminController::class, 'index'])->middleware('can:admin.home')->name('admin.home');

    Route::get('/updateuser/{user}', [AdminController::class, 'updateUser'])
        ->name('admin.update');

    Route::patch('/toggleUserStatus', [AdminController::class, 'toggleStatus'])
        ->middleware('can:admin.update')->name('toggleUserStatus');

    Route::put('/updateuserprocess/{user}', [AdminController::class, 'updateUserProcess'])
        ->middleware('can:admin.update')->name('admin.updateProcess');
});
