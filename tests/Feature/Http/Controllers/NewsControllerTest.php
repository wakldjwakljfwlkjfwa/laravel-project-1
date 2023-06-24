<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Author;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_news_by_author_returns_all_news_that_belongs_to_the_author(): void
    {
        $author = Author::factory()->create();
        News::factory(3)->create([
            'author_id' => $author->id,
        ]);
        $response = $this->get(route('api.news.by-author', ['author' => $author->id]));

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data', 3)
            ->etc());
    }
}
