<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $q = $request->validate(['q' => ['required', 'string', 'min:1', 'max:50']])['q'];

        $users = User::approved()
            ->where('username', 'ILIKE', "%{$q}%")
            ->where('id', '!=', $request->user()->id)
            ->select('id', 'username', 'prof_pic')
            ->limit(20)
            ->get();

        return response()->json($users);
    }

    public function show(string $username): JsonResponse
    {
        $user = User::approved()
                    ->where('username', $username)
                    ->select('id', 'username', 'prof_pic', 'created_at')
                    ->firstOrFail();

        return response()->json($user);
    }
}
