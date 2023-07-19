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
}
