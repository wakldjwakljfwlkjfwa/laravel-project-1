<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_example(): void
    {
        Author::factory(3)->create();
        $response = $this->get(route('api.authors.index'));

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data', 3)->etc()
        );
    }
}
