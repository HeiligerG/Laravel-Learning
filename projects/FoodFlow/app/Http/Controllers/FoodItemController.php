<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    // Dashboard View
    public function index()
    {
        $foodItems = FoodItem::orderBy('expiration_date', 'asc')->get();
        return view('dashboard', compact('foodItems'));
    }

    // Speichern eines neuen Lebensmittels
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'expiration_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        FoodItem::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Lebensmittel hinzugefügt!');
    }

    // Löschen eines Lebensmittels
    public function destroy(FoodItem $foodItem)
    {
        $foodItem->delete();
        return redirect()->route('dashboard')->with('success', 'Lebensmittel gelöscht!');
    }
}
