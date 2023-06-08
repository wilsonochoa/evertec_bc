<?php

namespace App\Http\Controllers\Api\User;

use App\Domain\Users\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ToggleUserStatusRequest;
use App\Http\Traits\ApiController;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{
    use ApiController;

    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        $rol = ModelsRole::where('name', 'Customer')->first();

        $users = User::with('roles')->whereHas('roles', function ($query) use ($rol) {
            $query->where('name', $rol->name);
        })->paginate(5);

        return $this->response($users);
    }

    public function toggleStatus(ToggleUserStatusRequest $request): array
    {
        $response = false;
        $params = $request->validated();
        try {
            $user = User::find($params['id']);
            if ($user->status === 1) {
                $user->status = 0;
            } else {
                $user->status = 1;
            }
            $response = $user->save();
            $responseData = 'Usuario actualizado';
        } catch (\Exception $e) {
            $responseData = 'Error al actualizar el usuario';
            Log::error($e->getMessage(), ['context' => 'Error al actualizar el estado del usuario']);
        }

        return $this->response($responseData, $response);
    }
}
