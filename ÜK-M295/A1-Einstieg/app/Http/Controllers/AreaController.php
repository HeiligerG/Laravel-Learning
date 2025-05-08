<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function getAreas()
    {
        $areas = Area::all();

        return response()->json($areas);
    }
}
