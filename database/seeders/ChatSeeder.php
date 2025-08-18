<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('status', 'approved')->get();
        $serviceProviders = User::role('service provider')->where('status', 'approved')->get();
        $clients = User::role('user')->where('status', 'approved')->get();

        // Create chat rooms between service providers and clients
        foreach ($serviceProviders as $provider) {
            // Create 2-4 chat rooms per service provider
            $chatCount = rand(2, 4);
            $selectedClients = $clients->random(min($chatCount, $clients->count()));

            foreach ($selectedClients as $client) {
                // Create chat room
                $room = ChatRoom::create([
                    'client_id' => $client->id,
                    'service_provider_id' => $provider->id,
                ]);

                // Create 5-15 messages per chat room
                $messageCount = rand(5, 15);
                $this->createMessages($room, $client, $provider, $messageCount);
            }
        }

        // Create some additional random chat rooms
        $additionalRooms = rand(5, 10);
        for ($i = 0; $i < $additionalRooms; $i++) {
            $provider = $serviceProviders->random();
            $client = $clients->random();

            // Check if room already exists
            $existingRoom = ChatRoom::where('client_id', $client->id)
                ->where('service_provider_id', $provider->id)
                ->first();

            if (!$existingRoom) {
                $room = ChatRoom::create([
                    'client_id' => $client->id,
                    'service_provider_id' => $provider->id,
                ]);

                // Create 3-8 messages
                $messageCount = rand(3, 8);
                $this->createMessages($room, $client, $provider, $messageCount);
            }
        }
    }

    private function createMessages($room, $client, $provider, $count)
    {
        $messages = [
            // Client messages
            [
                'user_id' => $client->id,
                'messages' => [
                    'Hi! I\'m interested in your services.',
                    'Can you tell me more about your packages?',
                    'What are your rates for a basic project?',
                    'Do you have any availability next week?',
                    'That sounds great! When can we start?',
                    'Thank you for the information.',
                    'I\'ll review the proposal and get back to you.',
                    'Can you send me some examples of your work?',
                    'What\'s included in the standard package?',
                    'Do you offer any discounts for long-term projects?'
                ]
            ],
            // Provider messages
            [
                'user_id' => $provider->id,
                'messages' => [
                    'Hello! Thanks for reaching out.',
                    'I\'d be happy to help you with your project.',
                    'Let me send you our current packages and pricing.',
                    'I have availability starting next Monday.',
                    'Great! I\'ll prepare a detailed proposal for you.',
                    'You\'re welcome! Let me know if you have any questions.',
                    'I\'ll send you some portfolio examples right away.',
                    'The standard package includes consultation, design, and implementation.',
                    'Yes, I offer 10% discount for projects over 3 months.',
                    'Looking forward to working with you!'
                ]
            ]
        ];

        $currentTime = now()->subDays(rand(1, 30));

        for ($i = 0; $i < $count; $i++) {
            $messageGroup = $messages[$i % 2];
            $messageText = $messageGroup['messages'][$i % count($messageGroup['messages'])];

            // Add some variation to messages
            $messageText = $this->addVariation($messageText);

            // Create message with some unread (null read_at)
            $isRead = rand(0, 1) === 1;

            ChatMessage::create([
                'chat_room_id' => $room->id,
                'user_id' => $messageGroup['user_id'],
                'message' => $messageText,
                'read_at' => $isRead ? $currentTime->addMinutes(rand(1, 60)) : null,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ]);

            $currentTime = $currentTime->addMinutes(rand(5, 120));
        }
    }

    private function addVariation($message)
    {
        $variations = [
            'Hi' => ['Hello', 'Hey there', 'Good morning', 'Good afternoon'],
            'interested' => ['looking for', 'need', 'want to explore'],
            'services' => ['work', 'offerings', 'packages'],
            'rates' => ['pricing', 'costs', 'fees'],
            'availability' => ['schedule', 'timeline', 'when you\'re free'],
            'start' => ['begin', 'commence', 'get going'],
            'information' => ['details', 'info', 'materials'],
            'proposal' => ['quote', 'estimate', 'plan'],
            'examples' => ['samples', 'portfolio', 'previous work'],
            'included' => ['comes with', 'features', 'contains']
        ];

        foreach ($variations as $original => $options) {
            if (stripos($message, $original) !== false) {
                $message = str_ireplace($original, $options[array_rand($options)], $message);
                break;
            }
        }

        return $message;
    }
}
