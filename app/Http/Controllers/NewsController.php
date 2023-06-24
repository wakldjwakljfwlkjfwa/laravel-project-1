<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Models\Author;
use App\Models\News;
use App\Models\NewsTopic;
use App\Models\Topic;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function newsByAuthor(Request $request, Author $author)
    {
        return $author->news()->paginate();
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::create([
            'title' => $request->title,
            'announcement' => $request->announcement,
            'content' => $request->content,
            'author_id' => $request->author_id,
        ]);

        foreach (($request->topics ?? []) as $topic) {
            NewsTopic::create([
                'news_id' => $news->id,
                'topic_id' => $topic,
            ]);
        }

        return $news;
    }

    public function search(Request $request, string $search)
    {
        return News::where('title', 'like', "%{$search}%")->paginate();
    }

    public function show(Request $request, News $news)
    {
        return $news;
    }

    public function newsByTopic(Request $request, Topic $topic)
    {
        return $topic->news()->paginate();
    }
}
