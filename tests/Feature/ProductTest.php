<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Testing\File;

class ProductTest extends TestCase
{
    public function test_store_method(): void
    {
        Sanctum::actingAs(User::factory()->setAdmin()->create());

        $image = UploadedFile::fake()->image('image.jpg');

        $response = $this->post('api/products', [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 1, 9999999),
            'description' => $this->faker->paragraph(2),
            'image' => $image,
            'in_stock' => true
        ]);

        $imageName = $response->decodeResponseJson()['image'];

        $this->assertDatabaseHas('products', [
            'image' => $imageName
        ]);

        $response->assertCreated();
    }

    public function test_index_method(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get('api/products');
        $response->assertOk();
    }

    public function test_index_method_as_admin(): void
    {
        Sanctum::actingAs(User::factory()->setAdmin()->create());

        $response = $this->get('api/products');
        $response->assertOk();
    }

    public function test_show_method(): void
    {
        $product = Product::factory()->create();
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get("api/products/{$product->id}");
        $response->assertOk();
    }

    public function test_show_method_as_admin(): void
    {
        $product = Product::factory()->create();
        Sanctum::actingAs(User::factory()->setAdmin()->create());

        $response = $this->get("api/products/{$product->id}");
        $response->assertOk();
    }

    public function test_destroy_method_as_admin(): void
    {
        $product = Product::factory()->create();
        Sanctum::actingAs(User::factory()->setAdmin()->create());

        $response = $this->delete("api/products/{$product->id}");

        $response->assertOk();
    }

    public function test_destroy_method_not_as_admin(): void
    {
        $product = Product::factory()->create();
        Sanctum::actingAs(User::factory()->create());

        $response = $this->delete("api/products/{$product->id}");

        $response->assertForbidden();
    }

    public function test_update_method_with_image(): void
    {
        Sanctum::actingAs(User::factory()->setAdmin()->create());

        $product = Product::factory()->create();

        $image = UploadedFile::fake()->image('image.jpg');
       
        $response = $this->put("api/products/{$product->id}",[
            'name' => "EDITED" . $this->faker->name() . "EDITED",
            'price' => 10.00,
            'description' => "EDITED" . $this->faker->paragraph(2) . "EDITED",
            'image' => $image
        ]
        );

        $this->assertDatabaseHas('products', [
            'image' => $response->decodeResponseJson()['image']
        ]);

        $response->assertOk();
    }

    public function test_update_method_with_out_image(): void
    {
        Sanctum::actingAs(User::factory()->setAdmin()->create());

        $product = Product::factory()->create();
       
        $response = $this->put("api/products/{$product->id}",[
            'name' => "EDITED" . $this->faker->name() . "EDITED",
            'price' => 10.00,
            'description' => "EDITED" . $this->faker->paragraph(2) . "EDITED",
        ]
        );

        $this->assertDatabaseHas('products', [
            'image' => $product->image
        ]);

        $response->assertOk();
    }
}
