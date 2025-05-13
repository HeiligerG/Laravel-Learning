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

    public function allPosts() {
        $posts = Post::get();
        return $posts;
    }

    public function getByPost($id) {
        $post = Post::find($id);
        return $post;
    }

    public function searchByPosts($search) {
        $posts = Post::where('title', 'LIKE', "%$search%")->get();
        return $posts;
    }

    public function getPostBySlug($slug) {
        $post = Post::where('slug', $slug)->first();
        return $post;
    }

    public function getPostByYear($year) {
        $posts = Post::whereYear('created_at', $year)->get();
        return $posts;
    }

    public function getPostByMaxPages($pages) {
        $posts = Post::where('pages', '<', $pages)->get();
        return $posts;
    }

    public function countPosts() {
        return Post::count();
    }

    public function countAvgPages($pages) {
        return Post::avg('pages');
    }
}
