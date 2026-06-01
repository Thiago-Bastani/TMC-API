<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER PUBLICATION supabase_realtime ADD TABLE friend_requests');
    }

    public function down(): void
    {
        DB::statement('ALTER PUBLICATION supabase_realtime DROP TABLE friend_requests');
    }
};
