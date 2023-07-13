<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductTest extends TestCase
{
    public function test_store_method(): void
    {
        $testUser = User::create([
            'name' => 'test',
            'email' => 'test@test.pl',
            'password' => '123123123',
            'is_admin' => 1,
            'phone' => 500600500,
        ]);
        
        Sanctum::actingAs($testUser);
        
        Storage::fake('images');
 
        $image = UploadedFile::fake()->image('image.jpg');
        Storage::disk('images')->putFile('images', $image);

        $response = $this->post('api/products',[
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(),
            'description' => $this->faker->paragraph(),
            'image' => $image,
            'in_stock' => true
        ]);

        $testUser->delete();
        $response->assertCreated();
        Storage::disk('images')->assertExists('images');
        
        
    }
}
