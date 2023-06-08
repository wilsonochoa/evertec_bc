<?php

namespace App\Http\Controllers\Api\User;

use App\Domain\Categories\Models\Category;
use App\Domain\Products\Actions\DisableProductsByCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Category\ToggleStatusRequest as RequestsToggleStatusRequest;
use App\Http\Traits\ApiController;
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
            $params = ['category_id' => $category->id, 'status' => $category->status];
            DisableProductsByCategory::execute($params);
        } catch (\Exception $e) {
            $responseData = 'Error al actualizar la categoria';
            Log::error($e->getMessage(), ['context' => 'Updating category status']);
        }

        return $this->response($responseData, $responseStatus);
    }
}
