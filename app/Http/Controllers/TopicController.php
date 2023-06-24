<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'exists:topics,id',
        ]);

        $topic = new Topic();
        $topic->name = $validated['name'];

        if ($validated['parent_id']) {
            $topic->parent_id = $validated['parent_id'];
        }

        $topic->save();

        return $topic;
    }
}
