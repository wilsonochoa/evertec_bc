<?php

namespace App\Http\Controllers\Web\User;

use App\Domain\Categories\Models\Category;
use App\Domain\Categories\ViewModels\EditViewModel;
use App\Domain\Categories\ViewModels\ListViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Category\CreateCategoryPostRequest;
use App\Http\Requests\Web\Category\UpdateCategoryPostRequest;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Category/List', new ListViewModel);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $params = $request->validated();
        if (Category::create($params)) {
            session()->flash('success', 'Categoría creada correctamente!');
        } else {
            session()->flash('error', 'Error al crear la categoría');
        }

        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Category $category): \Inertia\Response
    {
        return Inertia::render('Category/Edit', new EditViewModel($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, UpdateCategoryPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $params = $request->validated();
        if ($category->update($params)) {
            session()->flash('success', 'Categoría actualizada correctamente!');
        } else {
            session()->flash('error', 'Error al actualizar la categoría');
        }

        return redirect()->route('categories.index');
    }
}
