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
        $this->withoutExceptionHandling();
    }

    public function test_authors_index_returns_pagination(): void
    {
        Author::factory(3)->create();
        $response = $this->get(route('api.authors.index'));

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data', 3)->etc()
        );
    }

    public function test_author_store_creates_new_author()
    {
        $response = $this->post(route('api.authors.store'), [
            'name' => 'author 1',
            'email' => 'author1@email.com',
        ]);

        $response->assertStatus(201);
        $author = Author::all()->first();
        $this->assertEquals('author1@email.com', $author->email());
    }
}
