<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get list of all products
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Create a new product
     */
    public function store(Request $request)
    {
        // Check permission
        abort_unless(auth()->user()->can('products.create'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'pricing' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product->load('category'),
        ], 201);
    }

    /**
     * Get a specific product
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        // Check policy
        $this->authorize('view', $product);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * Update a specific product
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Check permission and policy
        abort_unless(auth()->user()->can('products.update'), 403);
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'pricing' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product->load('category'),
        ]);
    }

    /**
     * Delete a specific product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Check permission and policy
        abort_unless(auth()->user()->can('products.delete'), 403);
        $this->authorize('delete', $product);

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
