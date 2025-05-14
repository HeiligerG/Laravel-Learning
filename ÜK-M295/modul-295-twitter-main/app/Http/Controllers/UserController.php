<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\TweetResource;
use App\Http\Requests\UpdateUserRequest;

use App\Models\User;
use App\Models\Tweet;

class UserController extends Controller
{
    public function show(User $user)
    {
        return new UserResource($user);
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

    public function updateMe(UpdateUserRequest $request) {

        $user = $request->user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return new UserResource($user);

        return response()->json([
            'message' => 'Profil erfolgreich aktualisiert.',
            'user' => new UserResource($user),
        ], 422);
    }

    public function deleteMe() {
        $user = auth()->user();
        $user->delete();
        
        return response()->json([
            'message' => 'Profil erfolgreich gelöscht.',
        ], 200);
    }
}