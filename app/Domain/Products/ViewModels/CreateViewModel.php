<?php

namespace App\Domain\Products\ViewModels;

use App\Domain\Categories\Models\Category;
use App\Domain\Products\Models\Product;

class CreateViewModel extends \App\Support\ViewModels\ViewModel
{
    public function __construct()
    {
        parent::__construct(new Product());
    }

    public function toArray(): array
    {
        return [
            'title' => 'Crear producto',
            'categories' => Category::where('status', '1')->get(),
        ];
    }
}
