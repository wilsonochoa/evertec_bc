<?php

namespace Feature\Web\Admin\Category;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create()->assignRole('Admin');
    }

    public function test_customer_can_not_access_list(): void
    {
        $user = User::factory()->create()->assignRole('Customer');

        $response = $this->actingAs($user)->get(route('category.home'));

        $response->assertStatus(403);
    }

    public function test_admin_access_list(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('category.home'));
        $response->assertOk();
    }

    public function test_pagination(): void
    {
        $response = $this->actingAs($this->adminUser)->getJson(route('api.categories').'?page=2');
        $response->assertOk();
    }

    public function test_search(): void
    {
        $response = $this->actingAs($this->adminUser)->getJson(route('api.categories').'?filter=and');
        $response->assertOk();
    }
}
