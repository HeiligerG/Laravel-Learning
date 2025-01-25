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
        // Hole die aktuelle Community-ID des Benutzers
        $currentCommunityId = auth()->user()->current_community_id;

        // Fehler, wenn keine aktuelle Community gesetzt ist
        if (!$currentCommunityId) {
            abort(403, 'Benutzer hat keine aktive Community!');
        }

        // Optional: Prüfe, ob die Community existiert (falls Fremdschlüssel nicht gesetzt sind)
        $communityExists = Community::where('id', $currentCommunityId)->exists();
        if (!$communityExists) {
            abort(404, 'Community existiert nicht mehr!');
        }

        return $currentCommunityId; // Direkt die ID zurückgeben (Integer)
    }

    public function index(Request $request): View
    {
        $communityId = $this->getUserCommunityId();

        // Kategorien und Standorte für Dropdowns laden
        $categories = Category::where('community_id', $communityId)->get();
        $locations = Location::where('community_id', $communityId)->get();

        // FoodItems mit Filtern und Sortierung
        $foodItems = FoodItem::with(['category', 'location', 'community'])
            ->where('community_id', $communityId)
            ->when($request->search, fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->location, fn($q) => $q->where('location_id', $request->location))
            ->orderBy($request->sort ?? 'expiration_date', 'asc')
            ->paginate(12)
            ->withQueryString();

        // AJAX-Response
        if ($request->ajax()) {
            return view('item.partials.items', compact('foodItems'));
        }

        return view('dashboard.index', compact('foodItems', 'categories', 'locations'))
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

