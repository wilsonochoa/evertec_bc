<?php

namespace Tests\Feature;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create()->assignRole('Admin');
    }

    public function test_dashboard_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_customers_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->get('/lstuser');

        $response->assertStatus(200);
    }

    public function test_customers_pagination_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->get('/lstuser?page=2');

        $response->assertStatus(200);
    }

    public function test_customers_update_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->get('/updateuser/3');

        $response->assertStatus(200);
    }

    public function test_customers_update_is_displayed_failed(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->get('/updateuser/999');

        $response->assertStatus(404);
    }

    public function test_customers_toggle_status(): void
    {
        $response = $this->actingAs($this->adminUser)->patch(route('api.customers.toggleStatus'), ['id' => 1]);
        $response->assertOk()->assertJson(['status' => true]);
    }

    public function test_customers_toggle_status_failed(): void
    {
        $response = $this->actingAs($this->adminUser)->patch(route('api.customers.toggleStatus'), ['id' => 9999]);
        $response->assertFound();
    }

    public function test_customers_update(): void
    {
        $userAdmin = User::factory()->create()->assignRole('Admin');

        $randomName = $this->faker->name();

        $response = $this
            ->actingAs($userAdmin)
            ->put('/updateuserprocess/3', ['name' => $randomName]);

        $response->assertStatus(302);
        $response->assertRedirect('/lstuser');

        $this->assertEquals($randomName, User::find(3)->name);
    }
}
