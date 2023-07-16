<?php

namespace Jobs;

use App\Domain\Products\Models\Product;
use App\Domain\Users\Models\User;
use App\Jobs\ProductImportJob;
use App\Mail\ImportMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImportJobTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create()->assignRole('Admin');
    }

    public function test_import_products(): void
    {
        $currentProductsCount = Product::count();
        Mail::fake();
        (new ProductImportJob('../../public/formats/format_product_import.csv', $this->adminUser))->handle();
        Mail::assertSent(ImportMail::class);

        $this->assertDatabaseCount('products', ($currentProductsCount + 2));
        $this->assertDatabaseHas('products', [
            'name' => 'producto 1',
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'producto 2',
        ]);
    }

    public function test_import_products_failed(): void
    {
        $currentProductsCount = Product::count();

        Storage::fake();
        $user = User::factory()->create()->assignRole('Customer');

        (new ProductImportJob('../../public/formats/format_product_import.csv', $user))->handle();

        $this->assertDatabaseCount('products', $currentProductsCount);
    }
}
