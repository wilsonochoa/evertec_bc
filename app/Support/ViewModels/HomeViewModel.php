<?php

namespace App\Support\ViewModels;

use App\Domain\Categories\Models\Order;
use App\Domain\Products\Models\Product;
use Illuminate\Support\Facades\Route;

class HomeViewModel extends ViewModel
{
    public function __construct()
    {
        parent::__construct(new Product());
    }

    public function toArray(): array
    {
        return [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'categories' => Order::where('status', '1')->get(),
        ];
    }
}
