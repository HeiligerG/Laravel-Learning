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
        // Validierung der Eingabedaten
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'location' => 'required|exists:locations,id',
            'expiration_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        // Erstellen eines neuen Lebensmittel-Eintrags
        FoodItem::create([
            'name' => $validated['name'],
            'category_id' => $validated['category'],
            'location_id' => $validated['location'],
            'expiration_date' => $validated['expiration_date'],
            'quantity' => $validated['quantity'],
        ]);

        // Erfolgsnachricht und Weiterleitung
        return redirect()->route('dashboard')->with('success', 'Lebensmittel erfolgreich hinzugefügt.');
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
