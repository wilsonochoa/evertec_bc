<?php

namespace Database\Factories;

use App\Domain\Categories\Models\Category;
use App\Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Products\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = fake()->domainName();

        return [
            'name' => $name,
            'description' => fake()->sentence(100),
            'slug' => Str::slug($name, '-', 'es'),
            'image' => '',
            'price' => fake()->randomNumber(4),
            'quantity' => fake()->randomNumber(2),
            'status' => '1',
            'category_id' => fake()->randomElement(Category::all())['id'],
        ];
    }
}
