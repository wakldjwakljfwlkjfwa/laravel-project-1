<?php

namespace Tests\Feature\Models;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_author_model(): void
    {
        $user = User::factory()->create();
        $author = Author::create([
            'name' => 'author 1',
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseCount('authors', 1);
        $this->assertEquals($user->email, $author->email());
    }

    public function test_can_create_author_using_factory(): void
    {
        $author = Author::factory()->create();
        $this->assertDatabaseCount('authors', 1);
        $this->assertEquals($author->email(), $author->user->email);
    }
}
