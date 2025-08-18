<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => ['required', 'exists:chat_rooms,id'],
            'message' => ['required', 'string'],
        ]);

        $room = ChatRoom::findOrFail($data['room_id']);
        $user = $request->user();

        // Validate user is a participant in this chat room
        if ($room->client_id !== $user->id && $room->service_provider_id !== $user->id) {
            abort(403, 'You are not authorized to send messages in this chat room');
        }

        // Prevent sending messages in self-chats (additional safety check)
        if ($room->client_id === $room->service_provider_id) {
            abort(403, 'Cannot send messages in self-chat');
        }

        $message = $room->messages()->create([
            'user_id' => $user->id,
            'message' => $data['message'],
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return ['message' => $message->load('user')];
    }

    public function markAsRead(Request $request, ChatRoom $room)
    {
        $user = $request->user();

        // Validate user is a participant in this chat room
        if ($room->client_id !== $user->id && $room->service_provider_id !== $user->id) {
            abort(403, 'You are not authorized to access this chat room');
        }

        // Mark all unread messages in this room as read
        $updatedCount = $room->markMessagesAsRead($user->id);

        return response()->json([
            'success' => true,
            'messages_marked_as_read' => $updatedCount
        ]);
    }
}
