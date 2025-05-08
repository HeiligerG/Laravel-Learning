<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Author;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('topic', 'author')->get();
        return response()->json($posts);
    }
}
