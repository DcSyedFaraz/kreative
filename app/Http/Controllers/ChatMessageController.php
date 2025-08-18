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

        $message = ChatRoom::findOrFail($data['room_id'])->messages()->create([
            'user_id' => $request->user()->id,
            'message' => $data['message'],
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return ['message' => $message->load('user')];
    }
}
