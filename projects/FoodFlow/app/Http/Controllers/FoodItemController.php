<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Location;

class FoodItemController extends Controller
{
    public function index()
    {
        $foodItems = FoodItem::orderBy('expiration_date', 'asc')->get();
        $categories = Category::all(); // Alle Kategorien laden
        $locations = Location::all();  // Alle Standorte laden
        return view('dashboard', compact('foodItems', 'categories', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',  // Geändert von category_id
            'location' => 'required|exists:locations,id',   // Geändert von location_id
            'expiration_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        $foodItem = FoodItem::create([
            'name' => $validated['name'],
            'category_id' => $validated['category'],  // Hier category statt category_id
            'location_id' => $validated['location'],  // Hier location statt location_id
            'expiration_date' => $validated['expiration_date'],
            'quantity' => $validated['quantity'],
        ]);

        return redirect()->back()->with('success', 'Lebensmittel wurde erfolgreich hinzugefügt.');
    }
    public function addCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:categories']);
        $category = Category::create(['name' => $request->name]);
        return response()->json([
            'success' => true,
            'id' => $category->id,
            'message' => 'Kategorie hinzugefügt'
        ]);
    }

    public function addLocation(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:locations']);
        $location = Location::create(['name' => $request->name]);
        return response()->json([
            'success' => true,
            'id' => $location->id,
            'message' => 'Standort hinzugefügt'
        ]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
