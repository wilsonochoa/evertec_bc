<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            'status' => '1'
        ])->assignRole('Admin');

        User::create([
            'name' => 'wilson davis castillo ochoa',
            'email' => 'cliente@gmail.com',
            'password' => bcrypt('12345678'),
            'status' => '1'
        ])->assignRole('Customer');

        User::factory()->count(300)->create()->each(function ($user) {
            $user->assignRole('Customer');
        });;
    }
}
