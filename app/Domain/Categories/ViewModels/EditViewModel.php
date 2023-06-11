<?php

namespace App\Domain\Categories\ViewModels;

use App\Support\ViewModels\ViewModel;

class EditViewModel extends ViewModel
{
    public function toArray(): array
    {
        return [
            'title' => 'Editar categoría',
            'category' => $this->model,
        ];
    }
}
