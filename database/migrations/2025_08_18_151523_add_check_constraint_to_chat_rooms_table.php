<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, delete any existing self-chat records
        \DB::table('chat_rooms')->whereColumn('client_id', '=', 'service_provider_id')->delete();

        // Add check constraint to prevent self-chats
        \DB::statement('ALTER TABLE chat_rooms ADD CONSTRAINT chk_no_self_chat CHECK (client_id != service_provider_id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the check constraint
        \DB::statement('ALTER TABLE chat_rooms DROP CONSTRAINT IF EXISTS chk_no_self_chat');
    }
};
