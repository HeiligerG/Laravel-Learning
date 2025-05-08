<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Book;

class BookController extends Controller
{
    public function allPosts() {
        $posts = Post::all();
    }

    public function getByPost($id) {
        $post = Post::find($id);
    }

    public function searchByPosts($search) {
        $posts = Post::where('title', 'LIKE', "%$search%")->get();
    }

    public function getPostBySlug($slug) {
        $post = Post::where('slug', $slug)->first();
    }

    public function getPostByYear($year) {
        $posts = Post::whereYear('created_at', $year)->get();
    }

    public function getPostByMaxPages($pages) {
        $posts = Post::where('pages', '<', $pages)->get();
    }

    public function countPosts() {
        return Post::count();
    }

    public function countAvgPages($pages) {
        return Post::avg('pages');
    }

    public function getDasboard($pages, $year) {
        return [
            'books'  => Book::count(),
            'pages'  => Book::sum('pages'),
            'oldest' => Book::min('year'),
            'newest' => Book::max('year'),
        ];
    }
}
