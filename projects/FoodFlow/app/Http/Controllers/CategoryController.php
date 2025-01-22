<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Store\StoreCategoryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'success' => true,
            'message' => 'Kategorie hinzugefügt'
        ]);
    }
}
