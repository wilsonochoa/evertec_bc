<?php

namespace Feature\Web\Admin\Product;

use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImportProductTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create()->assignRole('Admin');
    }

    public function test_customer_can_not_access_form(): void
    {
        $user = User::factory()->create()->assignRole('Customer');

        $response = $this->actingAs($user)->get(route('products.import', 1));

        $response->assertStatus(403);
    }

    public function test_admin_access_form(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('products.import', 1));
        $response->assertOk();
    }

    public function test_create_product_with_csv(): void
    {
        $filePath = public_path('formats/format_product_import.csv');
        $file = new UploadedFile($filePath, 'data.csv', 'text/csv', null, true);
        $newData = [
            'file' => $file,
        ];
        $response = $this->actingAs($this->adminUser)->post(route('products.import.process', 1), $newData);
        $this->assertDatabaseHas('products', [
            'name' => 'producto 1',
        ]);
        $response->assertSessionHas('success');
        $response->assertRedirect(route('products.import'));
    }
}
