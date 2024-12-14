<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserProfile(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request, User $user)
    {
        if ($user->id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $fields = $request->validate([
            'name' => 'sometimes|max:255',
            'NIM' => 'sometimes|max:15',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $user->update($fields);

        return response()->json($user);
    }
}
