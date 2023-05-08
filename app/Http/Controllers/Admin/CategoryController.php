<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Requests\CreateCategoryPostRequest;
use App\Http\Requests\UpdateCategoryPostRequest;
use App\ViewModels\Admin\Category\ListViewModel;
use App\Models\Category;
use App\ViewModels\Admin\Category\EditViewModel;

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

        return redirect()->route('category.home');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): \Inertia\Response
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

        return redirect()->route('category.home');
    }

}
