<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community; // Community-Model importieren
use Illuminate\Support\Str; // Für Str::random()
use Illuminate\Support\Facades\Hash; // Für Hash::make()
use App\Http\Middleware\NoCommunityMiddleware;

class CommunityController extends Controller
{

    public function joinForm()
    {
        return view('community.join');
    }

    // Formular zur Erstellung
    public function createForm()
    {
        return view('community.create');
    }

    public function join(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|exists:communities,code'
        ]);

        $community = Community::where('code', $validated['code'])->firstOrFail();
        auth()->user()->communities()->attach($community->id);

        return redirect()->route('dashboard');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:communities,name',
            'password' => 'required|min:8'
        ]);

        $community = Community::create([
            'name' => $validated['name'],
            'code' => Str::random(8), // Generiert 8-stelligen Code
            'password' => Hash::make($validated['password'])
        ]);

        auth()->user()->communities()->attach($community->id);

        return redirect()->route('dashboard');
    }
}
