<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Tweet;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::all();

        $tweets = $tweets->map(function ($tweet) {
            $tweet->user = [
                "name" => "Franzi Musterfrau"
            ];
            return $tweet;
        });

        return response()->json([
            'data' => $tweets
        ]);
    }
}
