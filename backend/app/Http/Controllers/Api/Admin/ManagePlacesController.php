<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagePlacesController extends Controller
{
    public function index(Request $request)
    {
        $places = Place::orderBy('created_at', 'desc')->paginate(20);
        return response()->json([
            'status' => 'success',
            'data' => $places->items(),
            'meta' => [
                'total' => $places->total(),
                'current_page' => $places->currentPage(),
                'last_page' => $places->lastPage()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'area_name' => 'required|string',
            'area_zone' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'cover_image_url' => 'nullable|string',
            'budget_tier' => 'nullable|string',
            'budget_label' => 'nullable|string',
            'budget_range' => 'nullable|string',
            'tags' => 'nullable|array',
            'operating_hours' => 'nullable|array',
            'is_published' => 'boolean',
        ]);

        $validated['created_by'] = $request->user()->id;
        
        $place = Place::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $place
        ], 201);
    }

    public function show($id)
    {
        $place = Place::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $place
        ]);
    }

    public function update(Request $request, $id)
    {
        $place = Place::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string',
            'area_name' => 'sometimes|required|string',
            'area_zone' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'cover_image_url' => 'nullable|string',
            'budget_tier' => 'nullable|string',
            'budget_label' => 'nullable|string',
            'budget_range' => 'nullable|string',
            'tags' => 'nullable|array',
            'operating_hours' => 'nullable|array',
            'is_published' => 'boolean',
        ]);

        $place->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $place
        ]);
    }

    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Place deleted successfully'
        ]);
    }
}
