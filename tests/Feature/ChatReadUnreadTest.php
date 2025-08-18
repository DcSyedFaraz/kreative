<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatReadUnreadTest extends TestCase
{
    use RefreshDatabase;

    public function test_unread_messages_are_counted_correctly()
    {
        // Create users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create chat room
        $room = ChatRoom::create([
            'client_id' => $user1->id,
            'service_provider_id' => $user2->id,
        ]);

        // Create messages from user2 (unread by user1)
        ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user2->id,
            'message' => 'Hello from user2',
        ]);

        ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user2->id,
            'message' => 'Another message from user2',
        ]);

        // Create a message from user1 (should not count as unread for user1)
        ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user1->id,
            'message' => 'Hello from user1',
        ]);

        // Test unread count for user1
        $this->assertEquals(2, $room->getUnreadCountAttribute($user1->id));

        // Test unread count for user2
        $this->assertEquals(1, $room->getUnreadCountAttribute($user2->id));
    }

    public function test_messages_can_be_marked_as_read()
    {
        // Create users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create chat room
        $room = ChatRoom::create([
            'client_id' => $user1->id,
            'service_provider_id' => $user2->id,
        ]);

        // Create unread messages
        $message1 = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user2->id,
            'message' => 'Hello from user2',
        ]);

        $message2 = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user2->id,
            'message' => 'Another message from user2',
        ]);

        // Verify messages are unread initially
        $this->assertNull($message1->read_at);
        $this->assertNull($message2->read_at);
        $this->assertEquals(2, $room->getUnreadCountAttribute($user1->id));

        // Mark messages as read
        $updatedCount = $room->markMessagesAsRead($user1->id);

        // Verify messages are now read
        $this->assertEquals(2, $updatedCount);
        $this->assertEquals(0, $room->getUnreadCountAttribute($user1->id));

        // Refresh messages from database
        $message1->refresh();
        $message2->refresh();

        $this->assertNotNull($message1->read_at);
        $this->assertNotNull($message2->read_at);
    }

    public function test_last_message_is_retrieved_correctly()
    {
        // Create users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create chat room
        $room = ChatRoom::create([
            'client_id' => $user1->id,
            'service_provider_id' => $user2->id,
        ]);

        // Create messages with specific timestamps to ensure order
        $firstMessage = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user1->id,
            'message' => 'First message',
            'created_at' => now()->subMinutes(10),
            'updated_at' => now()->subMinutes(10),
        ]);

        // Wait a moment to ensure different timestamp
        sleep(1);

        $lastMessage = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user2->id,
            'message' => 'Last message',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Test last message retrieval
        $retrievedLastMessage = $room->getLastMessageAttribute();
        $this->assertNotNull($retrievedLastMessage);
        $this->assertEquals($lastMessage->id, $retrievedLastMessage->id);
        $this->assertEquals('Last message', $retrievedLastMessage->message);
    }
}
