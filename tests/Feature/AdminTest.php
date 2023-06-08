<?php

namespace Tests\Feature;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_dashboard_page_is_displayed(): void
    {
        $user = User::factory()->create()->assignRole('User');

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_customers_page_is_displayed(): void
    {
        $user = User::factory()->create()->assignRole('User');
        $response = $this
            ->actingAs($user)
            ->get('/lstuser');

        $response->assertStatus(200);
    }

    public function test_customers_pagination_is_displayed(): void
    {
        $user = User::factory()->create()->assignRole('User');
        $response = $this
            ->actingAs($user)
            ->get('/lstuser?page=2');

        $response->assertStatus(200);
    }

    public function test_customers_update_is_displayed(): void
    {
        $userAdmin = User::factory()->create()->assignRole('User');

        $response = $this
            ->actingAs($userAdmin)
            ->get('/updateuser/3');

        $response->assertStatus(200);
    }

    public function test_customers_update_is_displayed_failed(): void
    {
        $userAdmin = User::factory()->create()->assignRole('User');

        $response = $this
            ->actingAs($userAdmin)
            ->get('/updateuser/999');

        $response->assertStatus(404);
    }

    public function test_customers_toggle_status(): void
    {
        $userAdmin = User::factory()->create()->assignRole('User');

        $response = $this
            ->actingAs($userAdmin)
            ->patch('/toggleuserstatus', ['id' => 3]);

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }

    public function test_customers_toggle_status_failed(): void
    {
        $userAdmin = User::factory()->create()->assignRole('User');

        $response = $this
            ->actingAs($userAdmin)
            ->patch('/toggleuserstatus', ['id' => 9999]);

        $response->assertStatus(302);
    }

    public function test_customers_update(): void
    {
        $userAdmin = User::factory()->create()->assignRole('User');

        $randomName = $this->faker->name();

        $response = $this
            ->actingAs($userAdmin)
            ->put('/updateuserprocess/3', ['name' => $randomName]);

        $response->assertStatus(302);
        $response->assertRedirect('/lstuser');

        $this->assertEquals($randomName, User::find(3)->name);
    }
}
