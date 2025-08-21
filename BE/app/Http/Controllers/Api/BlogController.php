<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private function transform(Blog $blog)
    {
        return [
            'id'          => $blog->id,
            'category_id' => $blog->category_id,
            'title'       => $blog->title,
            'description' => $blog->description,
            'content'     => $blog->content,
            'image'       => $blog->image ? asset("storage/{$blog->image}") : null,
            'is_active'   => $blog->is_active,
            'created_at'  => $blog->created_at,
            'updated_at'  => $blog->updated_at,
        ];
    }

    public function index()
    {
        $blogs = Blog::all()->map(fn($blog) => $this->transform($blog));

        return $blogs->isEmpty()
            ? response()->json(['message' => 'Không có blog nào'], 404)
            : response()->json($blogs);
    }

    public function show($id)
    {
        $blog = Blog::find($id);

        return $blog
            ? response()->json($this->transform($blog))
            : response()->json(['message' => 'Blog không tồn tại'], 404);
    }
}
