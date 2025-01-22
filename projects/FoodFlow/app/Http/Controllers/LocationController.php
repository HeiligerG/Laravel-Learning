<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreLocationRequest;
use App\Models\Location;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationController extends Controller
{
    public function store(StoreLocationRequest $request): JsonResponse
    {
        $location = Location::create($request->validated());

        return response()->json([
            'id' => $location->id,
            'name' => $location->name,
            'success' => true,
            'message' => '  Standort hinzugefügt'
        ]);
    }
}
