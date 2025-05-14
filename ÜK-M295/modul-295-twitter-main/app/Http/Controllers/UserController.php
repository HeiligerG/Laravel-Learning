<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\TweetResource;

use App\Models\User;
use App\Models\Tweet;

class UserController extends Controller
{
    public function show($id)
    {
        $tweet = Tweet::with('user')->findOrFail($id);
        return new TweetResource($tweet);
    }

    public function tweets($id)
    {
        $user = User::findOrFail($id);

        $tweets = $user->tweets()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return TweetResource::collection($tweets);
    }

    public function me()
    {
        return new UserResource(auth()->user());
    }
}