<?php

namespace Tests\Feature\Models;

use App\Models\Author;
use App\Models\News;
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

    public function test_can_fetch_news_that_belong_to_author(): void
    {
        $author = Author::factory()->create();
        News::factory(3)->create([
            'author_id' => $author->id,
        ]);
        $this->assertCount(3, $author->news);
    }
}
