<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'announcement' => fake()->text(),
            'content' => fake()->text(),
            'published_at' => fake()->dateTime(),
            'author_id' => Author::factory(),
        ];
    }
}
