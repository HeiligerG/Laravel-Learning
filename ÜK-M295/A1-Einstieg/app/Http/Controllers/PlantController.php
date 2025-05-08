<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;

class PlantController extends Controller 
{
    public function getBySlug(string $slug)
    {
        $plant = Plant::where('slug', $slug)->with('area')->first();
        
        if (!$plant) {
            return response()->json(['message' => 'Plant not found'], 404);
        }
        
        return response()->json($plant);
    }
}
