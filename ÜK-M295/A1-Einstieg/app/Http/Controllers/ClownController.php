<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClownRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\DeleteClownRequest;
use App\Http\Requests\UpdateClownRequest;
use App\Models\Clown;

class ClownController extends Controller
{
    public function index() {
        $clowns = Clown::get();
        return $clowns;
    }

    public function show($id) {
        $clown = Clown::find($id);
        return $clown;
    }

    public function store(StoreClownRequest $request)
    {
        $clown = Clown::create($request->validated());
        return response()->json(['message' => 'Clown created.', 'clown' => $clown], 201);
    }

    public function update(UpdateClownRequest $request, $id)
    {
        $clown = Clown::findOrFail($id);
        $clown->update($request->validated());

        return response()->json([
            'message' => 'Clown updated successfully.',
            'clown' => $clown,
        ]);
    }

    public function destroy(DeleteClownRequest $request, $id): JsonResponse
    {
        $clown = Clown::find($id);

        if (!$clown) {
            return response()->json([
                'message' => 'Clown not found.',
            ], 404);
        }

        if ($clown->delete()) {
            return response()->json([
                'message' => 'Clown deleted successfully.',
                'clown' => $clown,
            ], 200);
        }

        return response()->json([
            'message' => 'Clown could not be deleted.',
        ], 500);
    }
}
