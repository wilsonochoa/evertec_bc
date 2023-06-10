<?php

namespace Database\Seeders;

use App\Domain\Categories\Models\Order;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()->count(20)->create();
    }
}
