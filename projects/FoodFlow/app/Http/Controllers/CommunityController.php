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
        $user = auth()->user();

        // Prüfen, ob der Benutzer bereits Mitglied ist
        if (!$user->communities->contains($community->id)) {
            // Beitreten und is_active = true setzen (Pivot-Tabelle)
            $user->communities()->attach($community->id, ['is_active' => true]);
        } else {
            // Aktivierung der bestehenden Mitgliedschaft (Pivot-Tabelle)
            $user->communities()->updateExistingPivot($community->id, ['is_active' => true]);
        }

        // Deaktiviere alle anderen Communities (Pivot-Tabelle)
        $user->communities()
            ->where('community_id', '!=', $community->id)
            ->each(function ($community) use ($user) {
                $user->communities()->updateExistingPivot($community->id, ['is_active' => false]);
            });

        // Aktuelle Community-ID in der users-Tabelle setzen
        $user->update(['current_community_id' => $community->id]);

        return redirect()->route('dashboard')->with('success', 'Community beigetreten!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:communities,name',
            'password' => 'required|min:8'
        ]);

        $community = Community::create([
            'name' => $validated['name'],
            'code' => Str::random(8),
            'password' => Hash::make($validated['password'])
        ]);

        $user = auth()->user();

        $user->communities()->attach($community->id, ['is_active' => true]);

        $user->communities()
            ->where('community_id', '!=', $community->id)
            ->each(function ($community) use ($user) {
                $user->communities()->updateExistingPivot($community->id, ['is_active' => false]);
            });

        $user->update(['current_community_id' => $community->id]);

        return redirect()->route('dashboard')->with('success', 'Community erstellt!');
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
            $user->communities()->updateExistingPivot($community->id, ['is_active' => true]);
        }

        $user->communities()
            ->where('community_id', '!=', $community->id)
            ->each(function ($community) use ($user) {
                $user->communities()->updateExistingPivot($community->id, ['is_active' => false]);
            });

        $user->update(['current_community_id' => $community->id]);

        return back()->with('success', 'Community gewechselt!');
    }
}
