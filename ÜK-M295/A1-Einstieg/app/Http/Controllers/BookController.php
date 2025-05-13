<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function getDasboard($pages, $year) {
        return [
            'books'  => Book::count(),
            'pages'  => Book::sum('pages'),
            'oldest' => Book::min('year'),
            'newest' => Book::max('year'),
        ];
    }
}
