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

        $rooms = ChatRoom::where('client_id', $user->id)
            ->orWhere('service_provider_id', $user->id)
            ->with(['client.profile', 'serviceProvider.profile'])
            ->get();

        return Inertia::render('Chat/Index', [
            'rooms' => $rooms,
            'userId' => $user->id,
        ]);
    }

    public function show(User $user)
    {
        $auth = request()->user();

        $room = ChatRoom::firstOrCreate(
            $auth->hasRole('service provider')
                ? ['client_id' => $user->id, 'service_provider_id' => $auth->id]
                : ['client_id' => $auth->id, 'service_provider_id' => $user->id]
        );

        $rooms = ChatRoom::where('client_id', $auth->id)
            ->orWhere('service_provider_id', $auth->id)
            ->with(['client.profile', 'serviceProvider.profile'])
            ->get();

        return Inertia::render('Chat/Room', [
            'room' => $room,
            'messages' => $room->messages()->with('user')->get(),
            'rooms' => $rooms,
            'userId' => $auth->id,
        ]);
    }
}
