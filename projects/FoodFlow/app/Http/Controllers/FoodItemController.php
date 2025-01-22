<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
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

    public function store(StoreFoodItemRequest $request): JsonResponse
    {
        // 1. Validierung via Form Request (automatisch)
        // 2. Neues FoodItem erstellen
        $foodItem = FoodItem::create($request->validated());

        // 3. Beziehungen laden (falls du sie direkt in der Response brauchst)
        $foodItem->load(['category', 'location']);

        // 4. JSON-Response zurückgeben
        return response()->json([
            'id'              => $foodItem->id,
            'name'            => $foodItem->name,
            'category'        => [
                'id'   => $foodItem->category->id,
                'name' => $foodItem->category->name,
            ],
            'location'        => [
                'id'   => $foodItem->location->id,
                'name' => $foodItem->location->name,
            ],
            'expiration_date' => $foodItem->expiration_date,
            'quantity'        => $foodItem->quantity,
            'created_at'      => $foodItem->created_at,
            'updated_at'      => $foodItem->updated_at,
            'success'         => true,
            'message'         => 'Lebensmittel hinzugefügt'
        ]);
    }

    public function destroy(FoodItem $foodItem): RedirectResponse
    {
        $foodItem->delete();
        return redirect()->back()->with('success', 'Lebensmittel wurde erfolgreich gelöscht.');
    }
}
