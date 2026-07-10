<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort_by')) {
            $direction = $request->get('sort_direction', 'asc');
            $query->orderBy($request->sort_by, $direction);
        }

        $perPage = $request->get('limit', 10);
        $products = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => new ProductCollection($products)
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product->load('category'))
        ]);
    }

    public function categories()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
}
