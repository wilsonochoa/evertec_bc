<?php

namespace App\Domain\Products\ViewModels;

use App\Domain\Categories\Models\Category;
use App\Domain\Products\Models\Product;

class ListViewModel extends \App\Support\ViewModels\ViewModel
{
    public function __construct()
    {
        parent::__construct(new Product());
    }

    public function toArray(): array
    {
        return [
            'title' => 'Productos',
            'categories' => Category::where('status', 1)->get(),
        ];
    }
}
