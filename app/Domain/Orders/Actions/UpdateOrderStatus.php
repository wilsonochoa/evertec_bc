<?php

namespace App\Domain\Orders\Actions;

use App\Domain\Orders\Models\Order;
use App\Support\Actions\Action;

class UpdateOrderStatus implements Action
{
    public static function execute(array $params): bool|int
    {
        return Order::where('id', $params['id'])->update(['status' => $params['status']]);
    }
}
