<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\ToggleStatusRequest as RequestsToggleStatusRequest;
use App\Http\Traits\ApiController;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    use ApiController;

    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        $categories = Category::latest('id')->paginate(5);
        return $this->response($categories);
    }

    public function toggleStatus(RequestsToggleStatusRequest $request): array
    {
        $params = $request->validated();
        $responseStatus = false;
        try {
            $category = Category::find($params['id']);

            if ($category->status == 1) {
                $category->status = 0;
            } else {
                $category->status = 1;
            }
            $responseStatus = $category->save();
            $responseData = 'Categoría actualizada';
        } catch (\Exception $e) {
            $responseData = 'Error al actualizar el usuario';
            Log::error($e->getMessage(), ['context' => 'Updating category status']);
        }

        return $this->response($responseData, $responseStatus);
    }
}