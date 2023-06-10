<?php

namespace Database\Factories;

use App\Domain\Categories\Models\Order;
use App\Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        if (env('APP_ENV') === 'testing') {
            Storage::fake('public');
        }

        return [
            'name' => fake()->domainName(),
            'description' => fake()->sentence(100),
            'slug' => fake()->slug(),
            'image' => 'products_images/0bO1rUsjcBMrbO5DsCKUpmuo6nRPW8sDamLSiWwh.jpg',
            'price' => fake()->randomNumber(4),
            'quantity' => fake()->randomNumber(2),
            'status' => '1',
            'category_id' => fake()->randomElement(Order::all())['id'],
        ];
    }
}
