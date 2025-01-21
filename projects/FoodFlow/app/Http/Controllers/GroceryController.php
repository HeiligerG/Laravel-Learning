<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class GroceryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('pages.add-grocery', [
            'categories' => $categories,
            'locations' => $locations,
        ]);
    }
}
