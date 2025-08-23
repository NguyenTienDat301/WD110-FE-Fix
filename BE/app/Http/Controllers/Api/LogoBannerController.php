<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogoBanner;
use Illuminate\Http\Request;

class LogoBannerController extends Controller
{
    public function index()
    {
        try {
            $groupedData = LogoBanner::all()
                ->groupBy('type')
                ->map(fn($items) => $items->map(fn($logo) => $this->formatLogoBanner($logo)));

            return response()->json($groupedData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->formatLogoBanner(LogoBanner::findOrFail($id)));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json(['message' => 'Logo/Banner không tồn tại'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    private function formatLogoBanner($logoBanner)
    {
        return [
            'id' => $logoBanner->id,
            'type' => $logoBanner->type,
            'title' => $logoBanner->title,
            'description' => $logoBanner->description,
            'image' => $logoBanner->image ? asset('storage/' . $logoBanner->image) : null,
            'is_active' => $logoBanner->is_active,
            'created_at' => $logoBanner->created_at,
            'updated_at' => $logoBanner->updated_at,
        ];
    }
}
