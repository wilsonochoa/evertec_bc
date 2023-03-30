<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    public function index()
    {
        
        $users = User::paginate(5);
        return Inertia::render('Admin/index', [
            'users' => $users,
        ]);
    }
}
