<?php

namespace App\Console\Commands;

use App\Models\ChatRoom;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixDuplicateChatRooms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:fix-duplicates {--dry-run : Show what would be done without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and fix duplicate chat rooms with reversed client_id and service_provider_id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('DRY RUN MODE - No changes will be made');
        }

        $this->info('Scanning for duplicate chat rooms...');

        // Find all chat rooms
        $rooms = ChatRoom::all();
        $duplicates = [];
        $processed = [];

        foreach ($rooms as $room) {
            $key1 = $room->client_id . '-' . $room->service_provider_id;
            $key2 = $room->service_provider_id . '-' . $room->client_id;

            // Skip if we've already processed this combination
            if (in_array($key1, $processed) || in_array($key2, $processed)) {
                continue;
            }

            // Find the reverse room
            $reverseRoom = ChatRoom::where('client_id', $room->service_provider_id)
                ->where('service_provider_id', $room->client_id)
                ->first();

            if ($reverseRoom && $room->id !== $reverseRoom->id) {
                $duplicates[] = [
                    'room1' => $room,
                    'room2' => $reverseRoom
                ];
                $processed[] = $key1;
                $processed[] = $key2;
            }
        }

        if (empty($duplicates)) {
            $this->info('No duplicate chat rooms found!');
            return 0;
        }

        $this->warn("Found " . count($duplicates) . " duplicate chat room pairs:");

        foreach ($duplicates as $index => $duplicate) {
            $room1 = $duplicate['room1'];
            $room2 = $duplicate['room2'];

            $this->line(($index + 1) . ". Room {$room1->id}: Client {$room1->client_id} ↔ Provider {$room1->service_provider_id}");
            $this->line("   Room {$room2->id}: Client {$room2->client_id} ↔ Provider {$room2->service_provider_id}");

            // Count messages in each room
            $messages1 = $room1->messages()->count();
            $messages2 = $room2->messages()->count();

            $this->line("   Messages: {$messages1} vs {$messages2}");

            if (!$isDryRun) {
                // Merge messages from room2 into room1, then delete room2
                if ($messages2 > 0) {
                    $this->line("   Moving {$messages2} messages from room {$room2->id} to room {$room1->id}...");

                    // Update all messages from room2 to point to room1
                    DB::table('chat_messages')
                        ->where('chat_room_id', $room2->id)
                        ->update(['chat_room_id' => $room1->id]);
                }

                // Delete the duplicate room
                $room2->delete();
                $this->line("   Deleted room {$room2->id}");
            }

            $this->line('');
        }

        if ($isDryRun) {
            $this->info('Run without --dry-run to apply these changes');
        } else {
            $this->info('Duplicate chat rooms have been fixed!');
        }

        return 0;
    }
}
