<?php

namespace Tests\Feature\Admin\Category;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create()->assignRole('Admin');
    }

    public function test_customer_can_not_access_form(): void
    {
        $user = User::factory()->create()->assignRole('Customer');

        $response = $this->actingAs($user)->get(route('category.create'));

        $response->assertStatus(403);
    }

    public function test_admin_access_form(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('category.create'));
        $response->assertOk();
    }

    public function test_save_category(): void
    {
        $newCategory = [
            'name' => fake()->name(),
            'status' => '1',
        ];
        $response = $this->actingAs($this->adminUser)->post(route('category.store'), $newCategory);
        $response->assertSessionHas('success');
        $response->assertRedirect(route('category.home'));
    }
}
