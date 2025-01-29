<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Store\StoreCategoryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $community = auth()->user()->communities()->first();
        if (!$community) {
            return response()->json(['error' => 'Benutzer ist keiner Community zugewiesen!'], 403);
        }

        $data = $request->validated();
        $data['community_id'] = $community->id;

        $category = Category::create($data);

        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'success' => true,
            'message' => 'Kategorie hinzugefügt'
        ]);
    }
}
