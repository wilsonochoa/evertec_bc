<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_dashboard_page_is_displayed(): void
    {
        Role::create(['name' => 'Customer']);
        $user = User::factory()->create()->assignRole('Customer');

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_customers_page_is_displayed(): void
    {
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer']);
        Permission::create(['name' => 'admin.home'])->assignRole($role);
        Permission::create(['name' => 'admin.update'])->assignRole($role);
        $user = User::factory()->create()->assignRole('Admin');
        User::factory()->count(20)->create()->each(function ($user) {
            $user->assignRole('Customer');
        });
        $response = $this
            ->actingAs($user)
            ->get('/lstuser');

        $response->assertStatus(200);
    }

    public function test_customers_pagination_is_displayed(): void
    {
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer']);
        Permission::create(['name' => 'admin.home'])->assignRole($role);
        Permission::create(['name' => 'admin.update'])->assignRole($role);
        $user = User::factory()->create()->assignRole('Admin');
        $response = $this
            ->actingAs($user)
            ->get('/lstuser?page=2');

        $response->assertStatus(200);
    }

    public function test_customers_update_is_displayed(): void
    {
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer']);
        Permission::create(['name' => 'admin.home'])->assignRole($role);
        Permission::create(['name' => 'admin.update'])->assignRole($role);
        $userAdmin = User::factory()->create()->assignRole('Admin');
        $userCustomer = User::factory()->create()->assignRole('Customer');

        $response = $this
            ->actingAs($userAdmin)
            ->get('/updateuser/' . $userCustomer->id);

        $response->assertStatus(200);
    }

    public function test_customers_update_is_displayed_failed(): void
    {
        $role = Role::create(['name' => 'Admin']);
        Permission::create(['name' => 'admin.home'])->assignRole($role);
        Permission::create(['name' => 'admin.update'])->assignRole($role);
        $userAdmin = User::factory()->create()->assignRole('Admin');

        $response = $this
            ->actingAs($userAdmin)
            ->get('/updateuser/999');

        $response->assertStatus(404);
    }

    public function test_customers_toggle_status(): void
    {
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer']);
        Permission::create(['name' => 'admin.home'])->assignRole($role);
        Permission::create(['name' => 'admin.update'])->assignRole($role);
        $userAdmin = User::factory()->create()->assignRole('Admin');
        $userCustomer = User::factory()->create()->assignRole('Customer');

        $response = $this
            ->actingAs($userAdmin)
            ->patch('/toggleuserstatus', ['id' => $userCustomer->id]);

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }

    public function test_customers_toggle_status_failed(): void
    {
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer']);
        Permission::create(['name' => 'admin.home'])->assignRole($role);
        Permission::create(['name' => 'admin.update'])->assignRole($role);
        $userAdmin = User::factory()->create()->assignRole('Admin');

        $response = $this
            ->actingAs($userAdmin)
            ->patch('/toggleuserstatus', ['id' => 9999]);

        $response->assertStatus(302);
    }

    public function test_customers_update(): void
    {
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer']);
        Permission::create(['name' => 'admin.home'])->assignRole($role);
        Permission::create(['name' => 'admin.update'])->assignRole($role);
        $userAdmin = User::factory()->create()->assignRole('Admin');
        $userCustomer = User::factory()->create()->assignRole('Customer');

        $randomName = $this->faker->name();

        $response = $this
            ->actingAs($userAdmin)
            ->put('/updateuserprocess/' . $userCustomer->id, ["name" => $randomName]);

        $response->assertStatus(302);
        $response->assertRedirect('/lstuser');

        $this->assertEquals($randomName, User::find($userCustomer->id)->name);
    }
}
