<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
        $category = Category::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return response()->json([
            'message' => 'Kategória bola úspešne vytvorená.'
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

        $category->update([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return response()->json([
            'message' => 'Kategória bola aktualizovaná.'
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
