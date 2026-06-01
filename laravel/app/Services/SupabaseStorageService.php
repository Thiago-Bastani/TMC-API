<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseStorageService
{
    private string $internalUrl;
    private string $publicUrl;
    private string $serviceKey;
    private string $bucket;

    public function __construct()
    {
        $this->internalUrl = rtrim(config('supabase.internal_url'), '/');
        $this->publicUrl   = rtrim(config('supabase.public_url'), '/');
        $this->serviceKey  = config('supabase.service_key');
        $this->bucket      = config('supabase.bucket');
    }

    public function upload(UploadedFile $file, int $senderId): array
    {
        $ext      = $file->getClientOriginalExtension();
        $path     = "messages/{$senderId}/" . Str::uuid() . ".{$ext}";
        $mime     = $file->getMimeType();
        $contents = file_get_contents($file->getRealPath());

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->serviceKey}",
            'Content-Type'  => $mime,
        ])->withBody($contents, $mime)
          ->post("{$this->internalUrl}/storage/v1/object/{$this->bucket}/{$path}");

        if ($response->failed()) {
            throw new \RuntimeException('File upload to Supabase Storage failed: ' . $response->body());
        }

        $publicUrl = "{$this->publicUrl}/storage/v1/object/public/{$this->bucket}/{$path}";

        return [
            'url'  => $publicUrl,
            'type' => $this->resolveMediaType($mime),
        ];
    }

    private function resolveMediaType(string $mime): string
    {
        if (str_contains($mime, 'gif')) {
            return 'gif';
        }
        if (str_contains($mime, 'image')) {
            return 'image';
        }
        return 'audio';
    }
}
