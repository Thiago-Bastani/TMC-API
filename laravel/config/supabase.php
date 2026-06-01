<?php

return [
    'internal_url' => env('SUPABASE_INTERNAL_URL', 'http://kong:8000'),
    'public_url'   => env('SUPABASE_PUBLIC_URL', 'http://localhost:8000'),
    'service_key'  => env('SUPABASE_SERVICE_KEY'),
    'anon_key'     => env('SUPABASE_ANON_KEY'),
    'bucket'       => env('SUPABASE_STORAGE_BUCKET', 'messages'),
];
