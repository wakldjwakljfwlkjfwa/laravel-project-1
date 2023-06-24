<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsTopicFactory extends Factory
{
    public function definition(): array
    {
        return [
            'news_id' => News::factory(),
            'topic_id' => Topic::factory(),
        ];
    }
}
