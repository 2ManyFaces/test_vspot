<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->paginate(500);
        return response()->json([
            'status' => 'success',
            'data' => $users->items(),
            'meta' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage()
            ]
        ]);
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => $user->is_active ? 'User unbanned successfully' : 'User banned successfully',
            'data' => $user
        ]);
    }
}
