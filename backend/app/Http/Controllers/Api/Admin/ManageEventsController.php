<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class ManageEventsController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::orderBy('event_date', 'desc')->paginate(20);
        return response()->json([
            'status' => 'success',
            'data' => $events->items(),
            'meta' => [
                'total' => $events->total(),
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'area_name' => 'required|string',
            'area_zone' => 'required|string',
            'organiser_name' => 'nullable|string',
            'cover_image_url' => 'nullable|string',
            'price_type' => 'required|in:free,paid',
            'price_amount' => 'nullable|numeric',
            'ticket_url' => 'nullable|string',
            'is_published' => 'boolean',
            'place_id' => 'nullable|exists:places,id',
        ]);

        $validated['created_by'] = $request->user()->id;
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . time();
        
        $event = Event::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $event
        ], 201);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $event
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'event_date' => 'sometimes|required|date',
            'end_date' => 'nullable|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'area_name' => 'sometimes|required|string',
            'area_zone' => 'sometimes|required|string',
            'organiser_name' => 'nullable|string',
            'cover_image_url' => 'nullable|string',
            'price_type' => 'sometimes|required|in:free,paid',
            'price_amount' => 'nullable|numeric',
            'ticket_url' => 'nullable|string',
            'is_published' => 'boolean',
            'place_id' => 'nullable|exists:places,id',
        ]);

        if (isset($validated['title']) && $validated['title'] !== $event->title) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . time();
        }

        $event->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $event
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully'
        ]);
    }
}
