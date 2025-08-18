<?php

namespace Tests\Feature;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ChatRoomDuplicateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'service provider']);
    }

    public function test_prevents_duplicate_chat_rooms()
    {
        // Create test users
        $client = User::factory()->create();
        $serviceProvider = User::factory()->create();

        // Assign roles
        $client->assignRole('user');
        $serviceProvider->assignRole('service provider');

        // First, create a chat room from client's perspective
        $room1 = ChatRoom::findOrCreateBetweenUsers($client->id, $serviceProvider->id);

        // Verify the room was created with correct structure
        $this->assertEquals($client->id, $room1->client_id);
        $this->assertEquals($serviceProvider->id, $room1->service_provider_id);

        // Now try to create a chat room from service provider's perspective
        $room2 = ChatRoom::findOrCreateBetweenUsers($serviceProvider->id, $client->id);

        // Should return the same room, not create a new one
        $this->assertEquals($room1->id, $room2->id);
        $this->assertEquals($client->id, $room2->client_id);
        $this->assertEquals($serviceProvider->id, $room2->service_provider_id);

        // Verify only one room exists in the database
        $this->assertEquals(1, ChatRoom::count());
    }

    public function test_handles_existing_rooms_with_reversed_relationships()
    {
        // Create test users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Assign roles
        $user1->assignRole('user');
        $user2->assignRole('service provider');

        // Manually create a room with reversed relationship (this simulates the old bug)
        $existingRoom = ChatRoom::create([
            'client_id' => $user2->id, // user2 as client
            'service_provider_id' => $user1->id, // user1 as service provider
        ]);

        // Now try to create a room using the new method
        $newRoom = ChatRoom::findOrCreateBetweenUsers($user1->id, $user2->id);

        // Should return the existing room, not create a new one
        $this->assertEquals($existingRoom->id, $newRoom->id);

        // Verify only one room exists in the database
        $this->assertEquals(1, ChatRoom::count());
    }

    public function test_determines_correct_roles_based_on_user_roles()
    {
        // Create test users
        $client = User::factory()->create();
        $serviceProvider = User::factory()->create();

        // Assign roles
        $client->assignRole('user');
        $serviceProvider->assignRole('service provider');

        // Create room using the new method
        $room = ChatRoom::findOrCreateBetweenUsers($client->id, $serviceProvider->id);

        // Should correctly assign client and service provider roles
        $this->assertEquals($client->id, $room->client_id);
        $this->assertEquals($serviceProvider->id, $room->service_provider_id);
    }

    public function test_handles_users_with_same_role()
    {
        // Create two users with the same role
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Both are regular users
        $user1->assignRole('user');
        $user2->assignRole('user');

        // Create room using the new method
        $room = ChatRoom::findOrCreateBetweenUsers($user1->id, $user2->id);

        // Should default to user1 as client, user2 as service provider
        $this->assertEquals($user1->id, $room->client_id);
        $this->assertEquals($user2->id, $room->service_provider_id);
    }
}
