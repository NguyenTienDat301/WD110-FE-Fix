<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Color, Product, Size};

class NewProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with(['categories:id,name', 'colors:id,name_color', 'sizes:id,size'])
                ->where('is_active', 1)
                ->latest()
                ->take(30)
                ->get()
                ->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'avatar_url' => $p->img_thumb ? asset("storage/{$p->img_thumb}") : null,
                    'categories' => $p->categories,
                    'price' => $p->min_price,
                    'view' => $p->view,
                    'colors' => $p->colors,
                    'sizes' => $p->sizes,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                ]);

            return response()->json([
                'products' => $products,
                'all_colors' => Color::all(),
                'all_sizes' => Size::all(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Không thể lấy danh sách sản phẩm. ' . $e->getMessage()
            ], 500);
        }
    }
}
