<?php

namespace App\Domain\Products\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        'price',
        'quantity',
        'status',
        'category_id',
    ];

    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }
}
