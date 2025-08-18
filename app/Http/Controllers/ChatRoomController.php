<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatRoomController extends Controller
{
    public function index()
    {
        $user = request()->user();

        $rooms = ChatRoom::where(function ($query) use ($user) {
                $query->where('client_id', $user->id)
                      ->orWhere('service_provider_id', $user->id);
            })
            ->whereColumn('client_id', '!=', 'service_provider_id') // Exclude chats with oneself
            ->with(['client.profile', 'serviceProvider.profile'])
            ->withCount([
                'messages as unread_count' => function($query) use ($user) {
                    $query->where('user_id', '!=', $user->id)
                          ->whereNull('read_at');
                }
            ])
            ->with(['messages' => function($query) {
                $query->with('user')->latest()->limit(1);
            }])
            ->get()
            ->map(function($room) {
                // Get the last message
                $room->last_message = $room->messages->first();
                unset($room->messages); // Remove the messages collection to avoid confusion
                return $room;
            });

        // Calculate total unread messages
        $totalUnread = $rooms->sum('unread_count');

        return Inertia::render('Chat/Index', [
            'rooms' => $rooms,
            'userId' => $user->id,
            'totalUnread' => $totalUnread,
        ]);
    }

    public function show($uuid)
    {
        $auth = request()->user();

        // Find the chat room by UUID
        $room = ChatRoom::findByUuid($uuid);

        if (!$room) {
            abort(404, 'Chat room not found');
        }

        // Check if the authenticated user is a participant in this chat room
        if ($room->client_id !== $auth->id && $room->service_provider_id !== $auth->id) {
            abort(403, 'You are not authorized to access this chat room');
        }

        $room->load(['client.profile', 'serviceProvider.profile']);

        // Mark messages as read when entering the room
        $room->markMessagesAsRead($auth->id);

        $rooms = ChatRoom::where(function ($query) use ($auth) {
                $query->where('client_id', $auth->id)
                      ->orWhere('service_provider_id', $auth->id);
            })
            ->whereColumn('client_id', '!=', 'service_provider_id') // Exclude chats with oneself
            ->with(['client.profile', 'serviceProvider.profile'])
            ->withCount([
                'messages as unread_count' => function($query) use ($auth) {
                    $query->where('user_id', '!=', $auth->id)
                          ->whereNull('read_at');
                }
            ])
            ->with(['messages' => function($query) {
                $query->with('user')->latest()->limit(1);
            }])
            ->get()
            ->map(function($room) {
                // Get the last message
                $room->last_message = $room->messages->first();
                unset($room->messages); // Remove the messages collection to avoid confusion
                return $room;
            });

        return Inertia::render('Chat/Room', [
            'room' => $room,
            'messages' => $room->messages()->with('user')->get(),
            'rooms' => $rooms,
            'userId' => $auth->id,
        ]);
    }

    /**
     * Create or find a chat room with a specific user
     */
    public function createWithUser(User $user)
    {
        $auth = request()->user();

        // Prevent creating/accessing chat with oneself
        if ($user->id === $auth->id) {
            abort(403, 'Cannot chat with yourself');
        }

        // Use the new method to find or create room, preventing duplicates
        $room = ChatRoom::findOrCreateBetweenUsers($auth->id, $user->id);

        // Redirect to the chat room using UUID
        return redirect()->route('chat.show', $room->uuid);
    }
}
