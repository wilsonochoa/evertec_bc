<?php

namespace App\Http\Controllers;

use App\ViewModels\HomeViewModel;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Welcome', new HomeViewModel);
    }
}
