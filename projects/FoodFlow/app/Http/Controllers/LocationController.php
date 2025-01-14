<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function store(StoreLocationRequest $request)
    {
        $location = Location::create($request->validated());

        return response()->json([
            'success' => true,
            'id' => $location->id,
            'message' => 'Standort hinzugefügt'
        ]);
    }

    public function show() : View
    {
        
    }
}
