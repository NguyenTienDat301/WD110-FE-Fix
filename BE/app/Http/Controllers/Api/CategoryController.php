<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::where('is_active', 1)->get());
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function productsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        return response()->json($products);
    }

    // Các hàm store, update, destroy để trống sẵn
    public function store(Request $request) {}
    public function update(Request $request, Category $category) {}
    public function destroy(Category $category) {}
}
