<?php

namespace App\Http\Controllers\Gst;

use App\Models\User;
use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role as ModelsRole;

class GstAdmin
{
    /**
     * @param $user
     * @param $data
     * Actualiza un registro en la tabla users
     * @return false
     */
    public static function updateUser(User $user, array $data): bool
    {
        $response = false;
        try {
            $response = $user->update($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['context' => "Se ha producido un error al actualizar el usuario"]);
        }
        return $response;
    }

    /**
     * Obtiene y retorna todos los usuarios con rol Customer
     * @return false
     */
    public static function getAllsUserPaginate(): Paginator
    {
        try {
            $rol = ModelsRole::where('name', 'Customer')->first();
            return User::with('roles')->whereHas('roles', function ($query) use ($rol) {
                $query->where('name', $rol->name);
            })->paginate(5);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['context' => "Error al consultar todos los usuarios"]);
        }
    }

    /**
     * @param $id
     * Actualiza el estado en la tabla users
     * @return false
     */
    public static function updateUserStatus(int $id): bool
    {
        $response = false;
        try {
            $user = User::find($id);
            if ($user->status == 1) {
                $user->status = 0;
            } else {
                $user->status = 1;
            }
            $response = $user->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['context' => "Error al actualizar el estado del usuario"]);
        }
        return $response;
    }
}
