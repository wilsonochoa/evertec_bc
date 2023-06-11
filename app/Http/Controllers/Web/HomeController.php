<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Support\ViewModels\HomeViewModel;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Welcome', new HomeViewModel);
    }
}
