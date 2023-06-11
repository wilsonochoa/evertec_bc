<?php

namespace App\Http\Controllers\Api;

use App\Domain\Orders\Actions\StoreOrder;
use App\Domain\Orders\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CreateApiRequest;
use App\Http\Resources\Api\StandardResource;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function getOrders()
    {
        return response()->json(new StandardResource(Order::latest('id')->paginate(5)));
    }

    public function store(CreateApiRequest $request): JsonResponse
    {
        $orderId = StoreOrder::execute($request->validated()['products']);
        if ($orderId) {
            return response()
                ->json(new StandardResource([
                    'route' => route('orders.show', $orderId),
                    'clear_cart' => true,
                    'set_max_amounts' => false,
                ]));
        }

        return response()->json(new StandardResource([
            'route' => false,
            'clear_cart' => false,
            'set_max_amounts' => true]));
    }
}
