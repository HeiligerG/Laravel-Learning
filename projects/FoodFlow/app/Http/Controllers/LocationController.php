<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreLocationRequest;
use App\Models\Location;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LocationController extends Controller
{
    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $location = Location::create($request->validated());

        return redirect()->route('locations.store')
        ->with('success', 'Standort erfolgreich hinzugefügt.');
    }
}
