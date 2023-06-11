<?php

namespace Tests\Feature\Api\Product;

use App\Domain\Users\Models\User;
use Tests\TestCase;

class ListProductsTest extends TestCase
{
    public function test_access_list(): void
    {
        $user = User::factory()->create()->assignRole('Customer');

        $response = $this->actingAs($user)->get(route('api.product.home').'?filter=and&category=1');
        $response->assertOk();
    }
}
