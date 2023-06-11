<?php

namespace App\Http\Controllers\Web;

use App\Domain\Orders\Models\Order;
use App\Domain\Orders\ViewModels\DetailViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Order/List');
    }

    public function show(Order $order): Response|RedirectResponse
    {
        return Inertia::render('Order/Detail', new DetailViewModel($order));
    }
}
