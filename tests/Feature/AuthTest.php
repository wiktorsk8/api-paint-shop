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
    public function test_register(): void
    {
        $email = $this->faker->email();

        $response = $this->post('api/register', [
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertCreated();

        $content = $response->decodeResponseJson();
        $token = substr($content['token'], 2);

        $this->assertDatabaseHas('personal_access_tokens', ['token' => hash('sha256', $token)]);
        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    public function test_register_redirect(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $email = $this->faker->email();

        $response = $this->post('api/register', [
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => $email]);
    }
}
