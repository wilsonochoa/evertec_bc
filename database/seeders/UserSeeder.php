<?php

namespace Database\Seeders;

use App\Domain\Users\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'wilson davis castillo ochoa',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'status' => '1',
            'email_verified_at' => now(),
        ])->assignRole('Admin');

        User::factory()->count(20)->create()->each(function ($user) {
            $user->assignRole('Customer');
        });
    }
}
