<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StuntingAiService
{
    public static function analisis(array $payload): ?array
    {
        try {
            $response = Http::timeout(30)
                ->post('http://ai:5005/stunting/analisis', $payload);
        } catch (\Throwable $e) {
            Log::error('AI CONNECTION ERROR: ' . $e->getMessage());
            return null;
        }

        if ($response->failed()) {
            Log::error('AI RESPONSE FAILED: ' . $response->body());
            return null;
        }

        return $response->json();
    }
}
