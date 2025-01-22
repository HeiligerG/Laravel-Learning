<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\View\View;

class FoodItemController extends Controller
{
    public function index(): View
    {
        $foodItems = FoodItem::with(['category', 'location'])->orderBy('expiration_date', 'asc')->get();
        return view('dashboard.index', compact('foodItems'));
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
        ], 201);

        return redirect()->back()->with('success', 'Lebensmittel wurde erfolgreich hinzugefügt.');
    }

    public function destroy(FoodItem $foodItem)
    {
        $foodItem->delete();
        return redirect()->back()->with('success', 'Lebensmittel wurde erfolgreich gelöscht.');
    }
}
