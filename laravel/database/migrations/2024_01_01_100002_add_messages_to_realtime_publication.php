<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add messages table to Supabase Realtime publication so inserts are broadcast via WebSocket
        DB::statement('ALTER PUBLICATION supabase_realtime ADD TABLE messages');
    }

    public function down(): void
    {
        DB::statement('ALTER PUBLICATION supabase_realtime DROP TABLE messages');
    }
};
