<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreLocationRequest;
use App\Models\Location;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationController extends Controller
{
    public function store(StoreLocationRequest $request): JsonResponse
    {
        $community = auth()->user()->communities()->first();
        if (!$community) {
            return response()->json(['error' => 'Benutzer ist keiner Community zugewiesen!'], 403);
        }

        $data = $request->validated();
        $data['community_id'] = $community->id;

        $location = Location::create($data);

        return response()->json([
            'id' => $location->id,
            'name' => $location->name,
            'success' => true,
            'message' => 'Standort hinzugefügt'
        ]);
    }
}
