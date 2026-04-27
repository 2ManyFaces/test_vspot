<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Update the authenticated user's profile details.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'display_name' => 'sometimes|required|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->has('display_name')) {
            $user->display_name = $validated['display_name'];
        }

        if ($request->has('bio')) {
            $user->bio = $validated['bio'];
        }
        
        if ($request->has('location')) {
            $user->location = $validated['location'];
        }

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if it's a local storage path
            if ($user->profile_photo_url && !str_starts_with($user->profile_photo_url, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->profile_photo_url));
            }
            
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo_url = '/storage/' . $path;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Retrieve the authenticated user's activity history.
     */
    public function activity(Request $request)
    {
        $user = $request->user();

        // Fetch filtered relations to ensure associated entities exist
        $reviews = $user->reviews()
            ->whereHas('place')
            ->with('place')
            ->orderBy('created_at', 'desc')
            ->get();

        $wishlist = $user->wishlistItems()
            ->where(function($q) {
                $q->whereHas('place')->orWhereHas('event');
            })
            ->with(['place', 'event'])
            ->orderBy('added_at', 'desc')
            ->get();

        $checkIns = $user->checkIns()
            ->where(function($q) {
                $q->whereHas('place')->orWhereHas('event');
            })
            ->with(['place', 'event'])
            ->orderBy('checked_in_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'reviews' => $reviews,
                'wishlist' => $wishlist,
                'check_ins' => $checkIns,
                'stats' => [
                    'review_count' => $reviews->count(),
                    'wishlist_count' => $wishlist->count(),
                    'check_in_count' => $checkIns->count(),
                ]
            ]
        ]);
    }
}
