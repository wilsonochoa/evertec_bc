<?php

namespace App\Http\Controllers\Web\User;

use App\Domain\Users\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\User\UpdateUserPostRequest;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('User/List');
    }

    public function updateUser(User $user): \Inertia\Response
    {
        return Inertia::render('User/Update', [
            'user' => $user,
        ]);
    }

    public function updateUserProcess(User $user, UpdateUserPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        if ($user->update($data)) {
            session()->flash('success', 'El Cliente se actualizó correctamente');
        } else {
            session()->flash('error', 'Se ha producido un error al actualizar el registro');
        }

        return redirect()->route('admin.home');
    }
}
