<?php

namespace App\Domain\Products\Actions;

use App\Domain\Products\Models\Product;
use App\Support\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateProduct implements Action
{
    /**
     * @param  array<string, array|Product>  $params
     */
    public static function execute(array $params): bool
    {
        $result = false;
        try {
            $fields = $params['fields'];
            $product = $params['product'];
            $fields['slug'] = Str::slug($fields['name'], '-', 'es');
            if (array_key_exists('image', $fields) && $fields['image'] !== null) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $fields['image'] = Storage::disk('public')->putFile('products_images', $fields['image']);
            } else {
                $fields['image'] = $product->image;
            }

            $result = $product->update($fields);
        } catch (\Exception $e) {
            logger()->warning('error'.$e->getMessage());
        }

        return $result;
    }
}
