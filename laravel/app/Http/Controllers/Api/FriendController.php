<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $friends = FriendRequest::accepted()
            ->where(fn($q) => $q->where('sender_id', $userId)->orWhere('receiver_id', $userId))
            ->with(['sender:id,username,prof_pic', 'receiver:id,username,prof_pic'])
            ->get()
            ->map(function ($fr) use ($userId) {
                return $fr->sender_id === $userId ? $fr->receiver : $fr->sender;
            });

        return response()->json($friends);
    }

    public function sendRequest(Request $request, string $username): JsonResponse
    {
        $me     = $request->user();
        $target = User::approved()->where('username', $username)->first();

        if (!$target) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($target->id === $me->id) {
            return response()->json(['message' => 'Cannot send a friend request to yourself.'], 422);
        }

        $exists = FriendRequest::where(function ($q) use ($me, $target) {
            $q->where('sender_id', $me->id)->where('receiver_id', $target->id);
        })->orWhere(function ($q) use ($me, $target) {
            $q->where('sender_id', $target->id)->where('receiver_id', $me->id);
        })->first();

        if ($exists) {
            return response()->json(['message' => 'A friend request already exists between you.'], 409);
        }

        $fr = FriendRequest::create([
            'sender_id'   => $me->id,
            'receiver_id' => $target->id,
            'status'      => 'pending',
        ]);

        return response()->json($fr, 201);
    }

    public function accept(Request $request, int $id): JsonResponse
    {
        $fr = FriendRequest::where('id', $id)
                           ->where('receiver_id', $request->user()->id)
                           ->where('status', 'pending')
                           ->firstOrFail();

        $fr->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend request accepted.']);
    }

    public function reject(Request $request, int $id): JsonResponse
    {
        $fr = FriendRequest::where('id', $id)
                           ->where('receiver_id', $request->user()->id)
                           ->where('status', 'pending')
                           ->firstOrFail();

        $fr->delete();

        return response()->json(['message' => 'Friend request rejected.']);
    }
}
