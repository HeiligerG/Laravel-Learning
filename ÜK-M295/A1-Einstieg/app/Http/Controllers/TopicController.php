<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class TopicController extends Controller
{
    public function postsBySlug(string $slug)
    {
        $topic = Topic::where('slug', $slug)->with('posts, author')->find();

        if (!$topic) {
            return response()->json(['message' => 'Topic not found'], 404);
        }

        return response()->json($topic->posts);
    }
}
