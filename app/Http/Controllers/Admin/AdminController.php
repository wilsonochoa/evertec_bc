<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPostRequest;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Gst\GstAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(): \Inertia\Response
    {
        $users = GstAdmin::getAllsUserPaginate();
        return Inertia::render('Admin/List', [
            'users' => $users,
        ]);
    }

    public function updateUser(User $user): \Inertia\Response
    {
        return Inertia::render('Admin/Update', [
            'user' => $user
        ]);
    }

    public function updateUserProcess(User $user, UpdateUserPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        if (GstAdmin::updateUser($user, $data)) {
            session()->flash('success', 'El Cliente se actualizó correctamente');
        } else {
            session()->flash('error', 'Se ha producido un error al actualizar el registro');
        }
        return redirect()->route('admin.home');
    }

    public function toggleStatus(Request $request): JsonResponse
    {
        $request->validate([
            'id' => ['required', 'numeric', 'exists:users']
        ]);

        return response()->json([
            'status' => GstAdmin::updateUserStatus($request->input('id'))
        ]);
    }
}
