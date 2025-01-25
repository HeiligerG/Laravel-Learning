<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\FoodItem;

class GroceryController extends Controller
{
    public function index(): View
    {
        $currentCommunity = auth()->user()
            ->communities()
            ->orderBy('community_user.updated_at', 'desc')
            ->first();

        if (!$currentCommunity) {
            abort(403, 'Benutzer ist keiner Community zugewiesen!');
        }

        $foodItems = FoodItem::with(['category', 'location'])
            ->where('community_id', $currentCommunity->id)
            ->orderBy('expiration_date', 'asc')
            ->paginate(12);

        $categories = Category::where('community_id', $currentCommunity->id)->get();
        $locations = Location::where('community_id', $currentCommunity->id)->get();

        return view('grocery.create', compact('foodItems', 'categories', 'locations'));
    }
}
