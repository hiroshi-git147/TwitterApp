<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LibreTranslateService
{
    protected string $baseUrl;

    public function __construct() {
        $this->baseUrl = config('services.libretranslate.url', 'https://libretranslate.com');
    }

    public function translate(string $text, string $targetLang, string $sourceLang = 'ja'): ?string
    {
        $response = Http::post("{$this->baseUrl}/translate", [
            'q' => $text,
            'source' => $sourceLang,
            'target' => $targetLang,
            'format' => 'text',
        ]);

        if($response->successful()) {
            return $response->json('translateText');
        }

        Log::error("LibreTranslate翻訳失敗: " . $response->body());
        return null;
    }


}
