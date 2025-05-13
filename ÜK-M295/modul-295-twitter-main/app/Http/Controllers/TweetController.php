<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Tweet;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::latest()
                        ->take(100)
                        ->get();

        $tweets = $tweets->map(function ($tweet) {
            $tweet->user = [
                "id" => $tweet->user_id,
                "name" => "Franzi Musterfrau"
            ];
            return $tweet;
        });

        return response()->json([
            'data' => $tweets
        ]);
    }
}
