<?php

namespace App\Http\Controllers\Api;

use App\Domain\Products\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiController;
use Illuminate\Http\Request;

class HomeController extends Controller
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
            'products.slug',
            'price',
            'quantity',
            'categories.name as category'
        )->where('products.status', 1)->where('quantity', '>', 0)
            ->when($filter, static function ($q) use ($filter) {
                $q->where('products.name', 'like', '%'.$filter.'%')
                ->orWhere('products.description', 'like', '%'.$filter.'%');
            })
            ->when($category, static function ($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->latest('products.id')->paginate(8);

        return $this->response($products);
    }
}
