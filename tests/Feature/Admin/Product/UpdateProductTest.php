<?php

namespace Tests\Feature\Admin\Product;

use App\Domain\Categories\Models\Category;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create()->assignRole('User');
    }

    public function test_customer_can_not_access_form(): void
    {
        $user = User::factory()->create()->assignRole('Customer');

        $response = $this->actingAs($user)->get(route('product.edit', 1));

        $response->assertStatus(403);
    }

    public function test_admin_access_form(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('product.edit', 1));
        $response->assertOk();
    }

    public function test_update_product_without_image(): void
    {
        $newData = [
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'status' => 1,
            'price' => fake()->randomNumber(4),
            'quantity' => fake()->randomNumber(4),
            'category_id' => Category::first()->id,
            'image' => null,
        ];
        $response = $this->actingAs($this->adminUser)->patch(route('product.update', 1), $newData);
        $response->assertSessionHas('success');
        $response->assertRedirect(route('product.home'));
    }

    public function test_update_product_with_image(): void
    {
        $newData = [
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'status' => 0,
            'price' => fake()->randomNumber(4),
            'quantity' => fake()->randomNumber(4),
            'category_id' => Category::first()->id,
            'image' => UploadedFile::fake()->image('product_image.png', 640, 480),
        ];
        $response = $this->actingAs($this->adminUser)->patch(route('product.update', 1), $newData);
        $response->assertSessionHas('success');
        $response->assertRedirect(route('product.home'));
    }
}
