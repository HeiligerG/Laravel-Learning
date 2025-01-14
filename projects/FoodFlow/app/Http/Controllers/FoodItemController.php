<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodItemController extends Controller
{
    public function index()
    {
        $foodItems = FoodItem::orderBy('expiration_date', 'asc')->get();
        $categories = Category::all();
        $locations = Location::all();
        return view('pages.dashboard', compact('foodItems', 'categories', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'location' => 'required|exists:locations,id',
            'expiration_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        $foodItem = FoodItem::create([
            'name' => $validated['name'],
            'category_id' => $validated['category'],
            'location_id' => $validated['location'],
            'expiration_date' => $validated['expiration_date'],
            'quantity' => $validated['quantity'],
        ]);

        return redirect()->back()->with('success', 'Lebensmittel wurde erfolgreich hinzugefügt.');
    }
}
