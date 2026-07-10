<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // List Products (Admin)
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection(Product::with('category')->get())
        ]);
    }

    // Create Product
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'image_urls' => $request->image_urls ?? [],
        ]);

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product->load('category'))
        ], 201);
    }

    // Update Product
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product->fresh()->load('category'))
        ]);
    }

    // Delete Product
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ]);
    }
}