<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Tweet;

class TweetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Tweet::all()
        ]);
    }
}
