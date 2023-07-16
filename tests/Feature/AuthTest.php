<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register():void {
        $response = $this->post('api/register', [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->randomNumber(9, true),
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertCreated();
    }

    public function test_register_redirect(): void {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $email = $this->faker->email();

        $response = $this->post('api/register', [
            'name' => $this->faker->name(),
            'email' => $email,
            'phone' => $this->faker->randomNumber(9, true),
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => $email]);
    }
}
