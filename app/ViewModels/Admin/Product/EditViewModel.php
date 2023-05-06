<?php

namespace App\ViewModels\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use App\ViewModels\ViewModel;

class EditViewModel extends ViewModel
{
    public function toArray(): array
    {
        return [
            'title' => 'Editar producto',
            'product' => $this->model,
            'categories' => Category::where('status', 1)->get()
        ];
    }
}
