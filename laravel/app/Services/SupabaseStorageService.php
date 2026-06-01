<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SupabaseStorageService
{
    public function upload(UploadedFile $file, int $senderId): array
    {
        $ext  = $file->getClientOriginalExtension();
        $mime = $file->getMimeType();
        $path = "messages/{$senderId}/" . Str::uuid() . ".{$ext}";

        Storage::disk('public')->putFileAs(
            "messages/{$senderId}",
            $file,
            basename($path)
        );

        $url = url("storage/messages/{$senderId}/" . basename($path));

        return [
            'url'  => $url,
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
