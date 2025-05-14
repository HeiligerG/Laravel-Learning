<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Http\Resources\TweetResource;
use App\Http\Requests\StoreTweetRequest;

use App\Models\Tweet;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return TweetResource::collection($tweets);
    }

    public function store(StoreTweetRequest $request)
    {
        $tweet = Tweet::create([
            'text' => $request->input('text'),
            'user_id' => $request->user()->id,
        ]);

        return new TweetResource($tweet);
    }

    public function like($id) {
        $tweet = Tweet::find($id);

        if (!$tweet) {
            return response()->json(['message' => 'Tweet not found'], 404);
        }

        $tweet->likes += 1;
        $tweet->save();

        return new TweetResource($tweet);
    }
}
