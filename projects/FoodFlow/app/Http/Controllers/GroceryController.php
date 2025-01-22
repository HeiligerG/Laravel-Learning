<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GroceryController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('grocery.create', compact('categories', 'locations'));
    }
}
