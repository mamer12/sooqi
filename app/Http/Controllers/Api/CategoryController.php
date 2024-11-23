<?php

namespace App\Http\Controllers\Api;


use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a list of categories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Show a single category
    public function show(Category $category)
    {
        return response()->json($category);
    }

    // Store a new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    // Update an existing category
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return response()->json($category);
    }

    // Delete a category
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
