<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
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
            'name' => 'required',
            'password' => 'required|min:8'
        ]);

        $community = Community::create([
            'name' => $validated['name'],
            'code' => Str::random(8),
            'password' => Hash::make($validated['password'])
        ]);

        auth()->user()->communities()->attach($community->id);

        return redirect()->route('dashboard');
    }
}
