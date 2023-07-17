<?php

namespace App\Http\Controllers\Api\User;

use App\Domain\Products\Actions\StoreProduct;
use App\Domain\Products\Actions\UpdateProduct;
use App\Domain\Products\Models\Product;
use App\Domain\Users\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ToggleStatusRequest;
use App\Http\Requests\Web\Product\CreateProductPostRequest;
use App\Http\Requests\Web\Product\UpdateProductPostRequest;
use App\Http\Resources\Api\StandardResource;
use App\Http\Traits\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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

    public function getToken(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(new StandardResource(['token' => $user->createToken('API TOKEN')->plainTextToken]));
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::select(
            'products.id',
            'products.name',
            'products.status',
            'description',
            'quantity',
            'slug',
            'image',
            'price',
            'categories.name as category'
        )
            ->where('products.id', $id)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->first();

        return response()->json(new StandardResource($product));
    }

    public function store(CreateProductPostRequest $request): JsonResponse
    {
        if (StoreProduct::execute($request->validated())) {
            return response()->json(new StandardResource(['status' => true, 'msg' => 'Product created']));
        }

        return response()->json(new StandardResource(['status' => false, 'msg' => 'Error']));
    }

    public function update(UpdateProductPostRequest $request, int $id): JsonResponse
    {
        $product = Product::find($id);
        if (! $product) {
            return response()->json(new StandardResource(['status' => false, 'msg' => 'Product not found']));
        }

        $fields = $request->validated();
        $params = [
            'fields' => $fields,
            'product' => $product,
        ];

        if (UpdateProduct::execute($params)) {
            return response()->json(new StandardResource(['status' => true, 'msg' => 'Product updated']));
        }

        return response()->json(new StandardResource(['status' => false, 'msg' => 'Error']));
    }
}
