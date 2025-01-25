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

        auth()->user()->update(['current_community_id' => $community->id]); // <-- HIER

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

        auth()->user()->update(['current_community_id' => $community->id]); // <-- HIER

        return redirect()->route('dashboard');
    }

    public function switch(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|exists:communities,code'
        ]);

        $community = Community::where('code', $validated['code'])->firstOrFail();
        $user = auth()->user();

        if (!$user->communities->contains($community->id)) {
            $user->communities()->attach($community->id, ['is_active' => true]);
        } else {
            // Aktiviere die Community explizit
            $user->communities()->updateExistingPivot($community->id, ['is_active' => true]);
        }

        $user->communities()
            ->where('community_id', '!=', $community->id)
            ->update(['is_active' => false]);

        $user->update(['current_community_id' => $community->id]);

        return back()->with('success', 'Community erfolgreich gewechselt');
    }
}
