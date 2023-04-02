<?php

namespace App\Http\Controllers\Gst;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class GstAdmin
{
    /**
     * @param $data
     * @param $id_user
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
}
