<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageRequest;
use App\Models\FriendRequest;
use App\Models\Message;
use App\Models\User;
use App\Services\SupabaseStorageService;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function store(SendMessageRequest $request, SupabaseStorageService $storage): JsonResponse
    {
        $me         = $request->user();
        $receiverId = $request->integer('receiver_id');

        $areFriends = FriendRequest::accepted()
            ->where(fn($q) => $q->where('sender_id', $me->id)->where('receiver_id', $receiverId))
            ->orWhere(fn($q) => $q->where('sender_id', $receiverId)->where('receiver_id', $me->id))
            ->exists();

        if (!$areFriends) {
            return response()->json(['message' => 'You can only message your friends.'], 403);
        }

        $mediaUrl  = null;
        $mediaType = null;

        if ($request->hasFile('file')) {
            $uploaded  = $storage->upload($request->file('file'), $me->id);
            $mediaUrl  = $uploaded['url'];
            $mediaType = $uploaded['type'];
        }

        $message = Message::create([
            'sender_id'   => $me->id,
            'receiver_id' => $receiverId,
            'content'     => $request->content,
            'media_url'   => $mediaUrl,
            'media_type'  => $mediaType,
        ]);

        return response()->json($message->load('sender:id,username,prof_pic'), 201);
    }
}
