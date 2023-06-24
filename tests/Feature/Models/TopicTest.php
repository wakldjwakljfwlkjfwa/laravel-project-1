<?php

namespace Tests\Feature\Models;

use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_topic_model(): void
    {
        Topic::create([
            'name' => 'topic',
        ]);
        $this->assertDatabaseCount('topics', 1);
    }

    public function test_can_create_topic_with_parent()
    {
        $parent = Topic::create(['name' => 'parent']);
        $child = Topic::create(['name' => 'child', 'parent_id' => $parent->id]);

        $this->assertEquals('parent', $child->parent->name);
        $this->assertEquals('child', $parent->children[0]->name);
    }

    public function test_can_create_topic_using_factory()
    {
        Topic::factory()->create();
        $this->assertDatabaseCount('topics', 1);
    }
}
