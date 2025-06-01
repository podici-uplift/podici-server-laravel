<?php

namespace App\Clients;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class GeminiClient extends BaseClient
{
    protected function client(): PendingRequest
    {
        return Http::baseUrl(config('services.gemini.base_url'))->withUrlParameters([
            'api_key' => config('services.gemini.api_key')
        ]);
    }

    public function generateContent(string $question)
    {
        return $this->client()->post("v1beta/models/gemini-2.0-flash:generateContent?key={api_key}", [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $question
                        ]
                    ]
                ]
            ]
        ]);
    }
}
