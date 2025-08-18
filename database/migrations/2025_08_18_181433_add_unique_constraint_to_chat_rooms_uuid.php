<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_rooms', function (Blueprint $table) {
            // Add the column if it doesn't exist
            $table->uuid('uuid')->nullable()->after('id');
        });

        // Populate UUIDs for rows missing it
        \DB::statement('UPDATE chat_rooms SET uuid = (UUID()) WHERE uuid IS NULL OR uuid = ""');

        // Now add the unique constraint
        Schema::table('chat_rooms', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_rooms', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
        });
    }
};
