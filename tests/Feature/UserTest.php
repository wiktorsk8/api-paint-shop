<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_index_unauth(){   
        $response = $this->get('api/users', ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }

    public function test_index_auth(){   
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get('api/users');

        $response->assertForbidden();
    }

    public function test_index_auth_admin(){   
        Sanctum::actingAs(User::factory()->setAdmin()->create());

        $response = $this->get('api/users');

        $response->assertOk();
    }

    public function test_show_method_admin(){
        Sanctum::actingAs(User::factory()->setAdmin()->create());
        $id = User::randomId();

        $response = $this->get("api/users/{$id}");

        $response->assertOk();
    }

    public function test_show_method_user_other(){
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $id = $user->id - 1;

        $response = $this->get("api/users/{$id}");

        $response->assertForbidden();
    }

    public function test_show_method_user_himself(){
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $id = $user->id;

        $response = $this->get("api/users/{$id}");

        $response->assertOk();
    }

    public function test_show_method_unauth(){
        $id = User::randomId();

        $response = $this->get("api/users/{$id}", ['Accept' => 'application/json']);

        $response->assertUnauthorized();
    }
}
