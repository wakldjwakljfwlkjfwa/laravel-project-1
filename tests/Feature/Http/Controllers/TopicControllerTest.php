<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TopicControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_topics_store_creates_new_topic(): void
    {
        $parent_topic = Topic::factory()->create();
        $response = $this->post(route('api.topics.store'), [
            'name' => 'topic 1',
            'parent_id' => $parent_topic->id,
        ]);

        $response->assertStatus(201);
        $response->assertJson(
            fn (AssertableJson $json) => $json->where('name', 'topic 1')->etc()
        );
    }
}
