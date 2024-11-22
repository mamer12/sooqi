<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display a list of products
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Show a single product
    public function show(Product $product)
    {
        return response()->json($product);
    }

    // Store a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    // Update an existing product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}

