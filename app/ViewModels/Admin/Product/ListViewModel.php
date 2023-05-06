<?php

namespace App\ViewModels\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use App\ViewModels\ViewModel;

class ListViewModel extends ViewModel
{
    public function __construct()
    {
        parent::__construct(new Product());
    }

    public function toArray(): array
    {
        return [
            'title' => 'Productos',
            'categories' => Category::where('status', 1)->get()
        ];
    }
}
