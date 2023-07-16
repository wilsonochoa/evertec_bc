<?php

namespace App\Http\Controllers\Api\User;

use App\Domain\Products\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ToggleStatusRequest;
use App\Http\Traits\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use ApiController;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): array
    {
        $filter = $request->get('filter');
        $category = $request->get('category');

        $products = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.image',
            'products.status',
            'price',
            'quantity',
            'categories.name as category'
        )
            ->when($filter, static function ($q) use ($filter) {
                $q->where('products.name', 'like', '%'.$filter.'%')
                    ->orWhere('products.description', 'like', '%'.$filter.'%');
            })
            ->when($category, static function ($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->latest('products.id')->paginate(5);

        return $this->response($products);
    }

    public function toggleStatus(ToggleStatusRequest $request): array
    {
        $params = $request->validated();
        $responseStatus = false;
        try {
            $product = Product::find($params['id']);

            if ($product->status === 1) {
                $product->status = 0;
            } else {
                $product->status = 1;
            }
            $responseStatus = $product->save();
            $responseData = 'Producto actualizado';
        } catch (\Exception $e) {
            $responseData = 'Error al actualizar el producto';
            Log::error($e->getMessage(), ['context' => 'Updating product status']);
        }

        return $this->response($responseData, $responseStatus);
    }
}
