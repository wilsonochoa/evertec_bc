<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Product\StoreProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductPostRequest;
use App\Http\Requests\Product\UpdateProductPostRequest;
use App\Models\Product;
use App\ViewModels\Admin\Product\CreateViewModel;
use App\ViewModels\Admin\Product\EditViewModel;
use App\ViewModels\Admin\Product\ListViewModel;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Product/List', new ListViewModel);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Product/Create', new CreateViewModel);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $params = $request->validated();
        if (StoreProduct::execute($params)) {
            session()->flash('success', 'Producto creado correctamente!');
        } else {
            session()->flash('error', 'Error al crear el producto');
        }
        return redirect()->route('product.home');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): \Inertia\Response
    {
        return Inertia::render('Product/Edit', new EditViewModel($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, UpdateProductPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $params = $request->validated();
        $params['image'] = $this->setImage($params, $product);

        if ($product->update($params)) {
            session()->flash('success', 'Producto actualizado correctamente!');
        } else {
            session()->flash('error', 'Error al actualizar el producto');
        }

        return redirect()->route('product.home');
    }

    private function setImage(array $requestParams, Product $product): string
    {
        if ($requestParams['image'] !== null) {
            Storage::disk('public')->delete($product->image);
            return Storage::disk('public')->putFile('products_images', $requestParams['image']);
        }
        return $product->image;
    }
}