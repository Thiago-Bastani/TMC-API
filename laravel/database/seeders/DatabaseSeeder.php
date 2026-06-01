<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->createStorageBucket();
    }

    private function createStorageBucket(): void
    {
        $internalUrl = rtrim(config('supabase.internal_url'), '/');
        $serviceKey  = config('supabase.service_key');
        $bucket      = config('supabase.bucket');

        if (!$serviceKey || !$internalUrl) {
            $this->command->warn('Supabase env vars not set — skipping bucket creation.');
            return;
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$serviceKey}",
            'Content-Type'  => 'application/json',
        ])->post("{$internalUrl}/storage/v1/bucket", [
            'id'     => $bucket,
            'name'   => $bucket,
            'public' => true,
        ]);

        if ($response->successful() || $response->status() === 409) {
            $this->command->info("Storage bucket '{$bucket}' ready.");
        } else {
            $this->command->warn("Could not create bucket: " . $response->body());
        }
    }
}
