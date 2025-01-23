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

        //

        return view('dashboard.index', compact('foodItems'));
    }

    public function store(StoreFoodItemRequest $request): RedirectResponse
    {
        // Debugging: Zeigen Sie die gesendeten Daten an

        // Erstellen Sie das FoodItem
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

    public function destroy(FoodItem $foodItem): RedirectResponse
    {
        $foodItem->delete();
        return redirect()->back()->with('success', 'Lebensmittel wurde erfolgreich gelöscht.');
    }
}
