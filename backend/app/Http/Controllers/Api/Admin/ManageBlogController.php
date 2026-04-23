<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManageBlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(20);
        return response()->json([
            'status' => 'success',
            'data' => $posts->items(),
            'meta' => [
                'total' => $posts->total(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'cover_image_url' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $validated['author_id'] = $request->user()->id;
        $validated['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        if ($request->is_published) {
            $validated['published_at'] = now();
        }
        
        $post = BlogPost::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $post
        ], 201);
    }

    public function show($id)
    {
        $post = BlogPost::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'excerpt' => 'nullable|string',
            'cover_image_url' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        if (isset($validated['is_published']) && $validated['is_published'] && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog post deleted successfully'
        ]);
    }
}
