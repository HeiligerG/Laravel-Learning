<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Store\StoreFoodItemRequest;
use App\Models\Category;
use App\Models\Location;
use App\Models\Community;
use App\Http\Requests\Update\UpdateFoodItemRequest;

class FoodItemController extends Controller
{

    private function getUserCommunityId()
    {
        // Holen Sie die Community des Benutzers (über die Many-to-Many-Beziehung)
        $community = auth()->user()->communities()->first();

        // Fehler, wenn keine Community zugewiesen ist
        if (!$community) {
            abort(403, 'Benutzer ist keiner Community zugewiesen!');
        }

        // Geben Sie die ID der Community zurück (als Integer)
        return $community->id;
    }

    public function index(): View
    {
        $communityId = $this->getUserCommunityId();

        $foodItems = FoodItem::with(['category', 'location', 'community'])
            ->where('community_id', $communityId) // Filter nach Community
            ->orderBy('expiration_date', 'asc')
            ->get();

        return view('dashboard.index', compact('foodItems'))
            ->with('success', session('success'));
    }

    public function store(StoreFoodItemRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Community-ID holen
            $data['community_id'] = $this->getUserCommunityId();

            // FoodItem erstellen
            FoodItem::create($data);

            return redirect()->route('dashboard')
                ->with('success', 'Lebensmittel erfolgreich hinzugefügt.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Fehler: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(FoodItem $foodItem)
    {
        if ($foodItem->community_id !== $this->getUserCommunityId()) {
            abort(403);
        }

        return view('item.show', [
            'foodItem' => $foodItem->load(['category', 'location'])
        ]);
    }

    public function destroy(FoodItem $foodItem): RedirectResponse
    {
        if ($foodItem->community_id !== $this->getUserCommunityId()) {
            abort(403);
        }

        try {
            $foodItem->delete();
            return redirect()->route('dashboard')
                ->with('success', 'Lebensmittel wurde erfolgreich gelöscht.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->withErrors(['error' => 'Fehler beim Löschen: ' . $e->getMessage()]);
        }
    }

    public function edit(FoodItem $foodItem)
    {
        if ($foodItem->community_id !== $this->getUserCommunityId()) {
            abort(403);
        }

        // Kategorien und Standorte NUR aus der aktuellen Community laden
        $communityId = $this->getUserCommunityId();
        $categories = Category::where('community_id', $communityId)->get();
        $locations = Location::where('community_id', $communityId)->get();

        return view('dashboard.edit', compact('foodItem', 'categories', 'locations'));
    }

    public function update(UpdateFoodItemRequest $request, FoodItem $foodItem)
    {
        if ($foodItem->community_id !== $this->getUserCommunityId()) {
            abort(403);
        }

        // Validierung in eine separate Request-Klasse auslagern (UpdateFoodItemRequest)
        $validatedData = $request->validated();

        try {
            $foodItem->update($validatedData);
            return redirect()->route('dashboard')
                ->with('success', 'Lebensmittel erfolgreich aktualisiert.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Fehler: ' . $e->getMessage()])
                ->withInput();
        }
    }
}

