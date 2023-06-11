<?php

namespace App\Domain\Products\ViewModels;

use App\Domain\Categories\Models\Category;

class EditViewModel extends \App\Support\ViewModels\ViewModel
{
    public function toArray(): array
    {
        return [
            'title' => 'Editar producto',
            'product' => $this->model,
            'categories' => Category::where('status', 1)->get(),
        ];
    }
}
