<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\News;
use App\Models\NewsTopic;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Authors
        $a1 = Author::factory()->create();
        $a2 = Author::factory()->create();

        // Topics
        $t1 = Topic::create([
            'name' => 'social',
        ]);

        $t2 = Topic::create([
            'name' => 'city life',
            'parent_id' => $t1->id,
        ]);

        $t3 = Topic::create([
            'name' => 'elections',
            'parent_id' => $t1->id,
        ]);

        $t4 = Topic::create([
            'name' => 'sports',
        ]);

        // News
        $n1 = News::factory()->create([
            'author_id' => $a1->id,
        ]);

        $n2 = News::factory()->create([
            'author_id' => $a2->id,
        ]);

        $n3 = News::factory()->create([
            'author_id' => $a2->id,
        ]);

        //News to Topics
        NewsTopic::create([
            'news_id' => $n1->id,
            'topic_id' => $t1->id,
        ]);

        NewsTopic::create([
            'news_id' => $n1->id,
            'topic_id' => $t2->id,
        ]);

        NewsTopic::create([
            'news_id' => $n2->id,
            'topic_id' => $t4->id,
        ]);

        NewsTopic::create([
            'news_id' => $n3->id,
            'topic_id' => $t3->id,
        ]);

    }
}
