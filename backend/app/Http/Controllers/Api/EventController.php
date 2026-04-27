<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('is_published', true);

        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $search . '%']);
            });
        }

        if ($request->has('category') && $request->category !== 'All' && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        $sort = $request->input('sort', 'date_asc');
        if ($sort === 'date_asc') {
            $query->orderBy('event_date', 'asc');
        } elseif ($sort === 'rating_desc') {
            $query->orderBy('average_rating', 'desc');
        } elseif ($sort === 'rating_asc') {
            $query->orderBy('average_rating', 'asc');
        } elseif ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        $events = $query->paginate(12);
            
        return response()->json([
            'status' => 'success',
            'data' => $events->items(),
            'meta' => [
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'total' => $events->total()
            ]
        ]);
    }

    public function show(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $reviews = $event->reviews()->with('user:id,display_name,profile_photo_url')->orderBy('created_at', 'desc')->get();
        
        $isWishlisted = false;
        $user = auth('sanctum')->user();
        if ($user) {
            $isWishlisted = \App\Models\WishlistItem::where('user_id', $user->id)
                ->where('event_id', $id)
                ->exists();
        }
        
        return response()->json([
            'status' => 'success',
            'data' => array_merge($event->toArray(), ['is_wishlisted' => $isWishlisted]),
            'reviews' => $reviews
        ]);
    }
}
