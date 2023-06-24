<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register(): void
    {
        $response = $this->post(route('api.auth.register'), [
            'name' => 'user 1',
            'email' => 'user1@email.com',
            'password' => '123456',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseCount('users', 1);
        $response->assertJson(fn (AssertableJson $json) => $json->has('token')->etc());
    }

    public function test_login(): void
    {
        $user = User::factory()->create();
        $response = $this->post(route('api.auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('token')->etc());
    }

    public function test_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('api.auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->post(route('api.auth.logout'));

        $response->assertStatus(200);
    }
}
