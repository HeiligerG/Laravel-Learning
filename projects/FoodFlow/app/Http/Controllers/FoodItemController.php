<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Store\StoreFoodItemRequest;
use App\Models\Category;
use App\Models\Location;

class FoodItemController extends Controller
{
    public function index(): View
    {
        $foodItems = FoodItem::with(['category', 'location'])
            ->where('community_id', auth()->user()->community_id)
            ->orderBy('expiration_date', 'asc')
            ->get();

        return view('dashboard.index', compact('foodItems'))
            ->with('success', session('success'));
    }

    public function store(StoreFoodItemRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['community_id'] = auth()->user()->community_id;

            $foodItem = FoodItem::create($data);

            return redirect()->route('dashboard')
                ->with('success', 'Lebensmittel erfolgreich hinzugefügt.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Fehler beim Hinzufügen: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(FoodItem $foodItem)
    {
        if ($foodItem->community_id !== auth()->user()->community_id) {
            abort(403);
        }

        return view('item.show', [
            'foodItem' => $foodItem->load(['category', 'location'])
        ]);
    }

    public function destroy(FoodItem $foodItem): RedirectResponse
    {
        if ($foodItem->community_id !== auth()->user()->community_id) {
            abort(403);
        }

        try {
            $foodItem->delete();
            return redirect()->route('dashboard')
                ->with('success', 'Lebensmittel wurde erfolgreich gelöscht.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->withErrors(['error' => 'Fehler beim Löschen des Lebensmittels: ' . $e->getMessage()]);
        }
    }

    public function edit(FoodItem $foodItem)
    {
        if ($foodItem->community_id !== auth()->user()->community_id) {
            abort(403);
        }

        $categories = Category::all();
        $locations = Location::all();

        return view('dashboard.edit', compact('foodItem', 'categories', 'locations'))
            ->with('success', session('success'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        if ($foodItem->community_id !== auth()->user()->community_id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'location_id' => 'required',
            'expiration_date' => 'required|date',
            'quantity' => 'required|integer',
        ]);

        try {
            $foodItem->update($validatedData);
            return redirect()->route('dashboard')
                ->with('success', 'Lebensmittel wurde erfolgreich aktualisiert.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->withErrors(['error' => 'Fehler beim Aktualisieren des Lebensmittels: ' . $e->getMessage()])
                ->withInput();
        }
    }
}

