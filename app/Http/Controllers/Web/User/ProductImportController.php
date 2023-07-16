<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Product\ProductsImportRequest;
use App\Jobs\ProductImportJob;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductImportController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Product/Import');
    }

    public function store(ProductsImportRequest $request): RedirectResponse
    {
        $file = $request->file('file')->store('imports');

        dispatch(new ProductImportJob($file, $request->user()));
        session()->flash('success', __('products.import_started'));

        return redirect()->route('products.import');
    }
}
