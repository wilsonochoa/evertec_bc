<?php

namespace App\Domain\Products\Actions;

use App\Domain\Products\Models\Product;

class DisableProductsByCategory implements \App\Support\Actions\Action
{
    public static function execute(array $params): bool
    {
        return Product::where('category_id', $params['category_id'])->update(
            ['status' => $params['status']]
        ) > 0;
    }
}
