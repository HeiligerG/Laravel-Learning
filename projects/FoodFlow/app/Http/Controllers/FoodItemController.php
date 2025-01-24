<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Store\StoreFoodItemRequest;
use App\Models\Category;
use App\Models\Location;

class FoodItemController extends Controller
{
    public function index(): View
    {
        $foodItems = FoodItem::with(['category', 'location'])->orderBy('expiration_date', 'asc')->get();

        return view('dashboard.index', compact('foodItems'));
    }

    public function store(StoreFoodItemRequest $request): RedirectResponse
    {
        try {
            $foodItem = FoodItem::create([
                'name' => $request->name,
                'expiration_date' => $request->expiration_date,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,  // Verwenden Sie 'category_id'
                'location_id' => $request->location_id,  // Verwenden Sie 'location_id'
            ]);

            return redirect()->route('foodItems.index')
                ->with('success', 'Lebensmittel erfolgreich hinzugefügt.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function show(FoodItem $foodItem)
    {
        return view('item.show', [
            'foodItem' => $foodItem->load(['category', 'location'])
        ]);
    }

    public function destroy(FoodItem $foodItem): RedirectResponse
    {
        $foodItem->delete();
        return redirect()->route('dashboard')->with('success', 'Lebensmittel wurde erfolgreich gelöscht.');
    }

    public function edit(FoodItem $foodItem)
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('dashboard.edit', compact('foodItem', 'categories', 'locations'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'location_id' => 'required',
            'expiration_date' => 'required|date',
            'quantity' => 'required|integer',
        ]);

        $foodItem->update($validatedData);
        return redirect()->route('dashboard')->with('success', 'Lebensmittel wurde erfolgreich aktualisiert.');
    }
}
