<?php

namespace App\Http\Controllers\Api;

use App\Domain\Products\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ValidQuantityProductRequest;
use App\Http\Resources\Api\StandardResource;
use App\Http\Traits\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiController;

    public function getCartProducts(Request $request): JsonResponse
    {
        $ids = $request->post('ids');

        $products = Product::select('id', 'name', 'slug', 'image', 'price', 'quantity')->whereIn('id', $ids)->get();

        return response()->json(new StandardResource($products));
    }

    public function validQuantityProduct(ValidQuantityProductRequest $request)
    {
        $data['response'] = true;
        $params = $request->validated();
        $product = Product::find($params['id']);
        if ($params['amount'] >= $product->quantity) {
            $data['response'] = false;
        }

        return response()->json(new StandardResource($data));
    }
}
