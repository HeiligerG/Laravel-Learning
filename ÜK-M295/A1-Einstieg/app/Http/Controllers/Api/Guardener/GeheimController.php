<?php

namespace App\Http\Controllers\Api\Guardener;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GeheimController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'location' => 'Ebikonerstrasse 75, Adligenswil'
        ]);
    }
}

