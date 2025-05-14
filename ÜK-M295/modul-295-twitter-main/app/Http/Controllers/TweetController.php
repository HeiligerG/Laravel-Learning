<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Resources\TweetResource;

use App\Models\Tweet;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::with('user')
                    ->latest()
                    ->take(100)
                    ->get();

        return TweetResource::collection($tweets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:5|max:160',
        ]);

        $tweet = Tweet::create([
            'text' => $request->input('text'),
            'user_id' => $request->user()->id,
        ]);

        return new TweetResource($tweet);
    }
}
