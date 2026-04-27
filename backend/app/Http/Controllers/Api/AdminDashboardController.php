<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Event;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function stats(Request $request)
    {
        $last7Days = collect(range(0, 6))->map(function($i) {
            return Carbon::now()->subDays($i)->format('Y-m-d');
        })->reverse()->values();

        $recentActivity = $last7Days->map(function($date) {
            return [
                'date' => Carbon::parse($date)->format('M d'),
                'reviews' => Review::whereDate('created_at', $date)->count(),
            ];
        });

        $userGrowth = $last7Days->map(function($date) {
            return [
                'date' => Carbon::parse($date)->format('M d'),
                'users' => User::whereDate('created_at', $date)->count(),
            ];
        });

        $categoryDistribution = Place::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get();

        $stats = [
            'total_users' => User::count(),
            'total_places' => Place::count(),
            'total_events' => Event::count(),
            'total_reviews' => Review::count(),
            'recent_activity' => $recentActivity,
            'user_growth' => $userGrowth,
            'category_distribution' => $categoryDistribution,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }
}
