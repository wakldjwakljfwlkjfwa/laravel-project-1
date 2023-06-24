<?php

namespace Tests\Feature\Models;

use App\Models\Author;
use App\Models\News;
use App\Models\NewsTopic;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_news_model(): void
    {
        $author = Author::factory()->create();
        News::create([
            'title' => 'title 1',
            'announcement' => 'announcement 1',
            'content' => 'content 1',
            'published_at' => now(),
            'author_id' => $author->id,
        ]);
        $this->assertDatabaseCount('news', 1);
    }

    public function test_can_create_news_using_factory()
    {
        News::factory()->create();
        $this->assertDatabaseCount('news', 1);
    }

    public function test_can_create_news_with_topic()
    {
        $topic = Topic::factory()->create();
        $news = News::factory()->create();
        $news_topic = NewsTopic::create([
            'news_id' => $news->id,
            'topic_id' => $topic->id,
        ]);

        $this->assertDatabaseCount('news_topics', 1);
        $this->assertEquals($topic->name, $news_topic->topic->name);
        $this->assertEquals($news->title, $news_topic->news->title);
        $this->assertEquals($news->title, $topic->news[0]->title);
        $this->assertEquals($topic->name, $news->topics[0]->name);
    }
}
