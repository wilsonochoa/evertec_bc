<?php

namespace App\Domain\Categories\ViewModels;

use App\Domain\Categories\Models\Order;

class ListViewModel extends \App\Support\ViewModels\ViewModel
{
    public function __construct()
    {
        parent::__construct(new Order());
    }

    public function toArray(): array
    {
        return ['title' => 'Categorías'];
    }
}
