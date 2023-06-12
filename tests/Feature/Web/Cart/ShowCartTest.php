<?php

namespace Tests\Feature\Web\Cart;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ShowCartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customerUser = User::factory()->create()->assignRole('Customer');
    }

    public function test_cart_view(): void
    {
        $this->actingAs($this->customerUser)->get(route('cart'))->assertOk()->assertInertia(
            fn (Assert $page) => $page->component('CartDetail')
        );
    }
}
