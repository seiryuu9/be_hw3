<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return response()->json([
            'categories' => $categories
        ], Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'min:2', 'max:255', 'unique:categories,name'],
            'color' => ['required', 'string', 'regex:/^#([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message'  => 'Kategória bola úspešne vytvorená.',
            'category' => $category,
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Kategória nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'category' => $category
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Kategória nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name'  => ['sometimes', 'required', 'string', 'min:2', 'max:255',
                Rule::unique('categories', 'name')->ignore($category->id)],
            'color' => ['sometimes', 'required', 'string', 'regex:/^#([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
        ]);

        $category->update($validated);

        return response()->json([
            'message'  => 'Kategória bola aktualizovaná.',
            'category' => $category,
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Kategória nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return response()->json([
            'message' => 'Kategória bola odstránená.'
        ], Response::HTTP_OK);
    }

}
