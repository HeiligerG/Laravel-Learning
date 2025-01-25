<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\FoodItem;

class GroceryController extends Controller
{
    public function index(): View
    {
        $community = auth()->user()->communities()->first();

        if (!$community) {
            abort(403, 'Benutzer ist keiner Community zugewiesen!');
        }

        $categories = Category::where('community_id', $community->id)->get();
        $locations = Location::where('community_id', $community->id)->get();

        return view('grocery.create', compact('categories', 'locations'));
    }
}
