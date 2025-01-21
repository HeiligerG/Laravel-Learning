<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreLocationRequest;
use App\Models\Location;

class LocationController extends Controller
{
    public function store(StoreLocationRequest $request)
    {
        $location = Location::create($request->validated());

        return response()->json([
            'success' => true,
            'id' => $location->id,
            'message' => '  Standort hinzugefügt'
        ]);
    }
}
