<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ImageService
{
    public static function uploadImage(UploadedFile $image): ?string
    {
        $response = Http::attach(
            'image',
            file_get_contents($image->path()),
            $image->getClientOriginalName()
        )->post(config('media.url') . '/upload');

        $responseBody = json_decode($response->body());

        if ($response->status() == Response::HTTP_OK) {
            return $responseBody?->id;
        } else {
            Log::error($response->body());
            throw new Exception(__('messages.failedToUpload'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public static function deleteFromStorage(string $image): void
    {
        Http::delete(config('media.url') . '/upload/' . $image);
    }
}
