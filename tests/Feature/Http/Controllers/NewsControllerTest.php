<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Author;
use App\Models\News;
use App\Models\NewsTopic;
use App\Models\Topic;
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
        $this->withoutExceptionHandling();
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

    public function test_store_news_creates_new_news(): void
    {
        $author = Author::factory()->create();
        $topic1 = Topic::factory()->create();
        $topic2 = Topic::factory()->create();

        $response = $this->post(route('api.news.store', [
            'title' => 'title 1',
            'announcement' => 'announcement 1',
            'content' => 'content 1',
            'author_id' => $author->id,
            'topics' => [
                $topic1->id,
                $topic2->id,
            ],
        ]));

        $response->assertStatus(201);
        $news_id = $response->json()['id'];
        $news = News::find($news_id);
        $this->assertCount(2, $news->topics);
        $response->assertJson(fn (AssertableJson $json) => $json->where('title', 'title 1')->etc());
    }

    public function test_news_search_returns_news_that_match_the_title(): void
    {
        News::factory()->create(['title' => 'title 2']);
        $news = News::factory()->create(['title' => 'news title 1']);

        $response = $this->get(route('api.news.search', ['search' => 'title 1']));

        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data', 1)->where('data.0.title', $news->title)->etc()
        );
    }

    public function test_news_show_returns_news_by_id(): void
    {
        $news = News::factory()->create();
        $response = $this->get(route('api.news.show', [
            'news' => $news->id,
        ]));

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->where('title', $news->title)->etc());
    }

    public function test_news_by_topic_returns_only_news_that_belong_to_the_topic(): void
    {
        $topic = Topic::factory()->create();
        $news = News::factory(3)->create();
        News::factory(2)->create();

        foreach ($news as $n) {
            NewsTopic::create([
                'news_id' => $n->id,
                'topic_id' => $topic->id,
            ]);
        }

        $response = $this->get(route('api.news.by-topic', ['topic' => $topic->id]));

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->has('data', 3)->etc());
    }
}
