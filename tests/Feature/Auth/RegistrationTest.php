<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Seeder;
use Tests\TestCase;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $role1 = Role::create(['name'=>'Admin']);
        $role2 = Role::create(['name'=>'Customer']);
        Permission::create(['name'=> 'admin.home'])->assignRole($role1);
        Permission::create(['name'=> 'admin.update'])->assignRole($role1);
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
