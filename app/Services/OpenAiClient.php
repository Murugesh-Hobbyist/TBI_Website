<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenAiClient
{
    private string $apiKey;
    private string $baseUrl;
    private int $timeoutSeconds;

    public function __construct()
    {
        $this->apiKey = (string) config('assistant.openai_api_key');
        $this->baseUrl = rtrim((string) config('assistant.base_url'), '/');
        $this->timeoutSeconds = (int) config('assistant.timeout_seconds', 45);

        if ($this->apiKey === '') {
            throw new RuntimeException('Missing OPENAI_API_KEY');
        }
    }

    public function responsesCreate(array $payload): array
    {
        return $this->json('POST', '/v1/responses', $payload);
    }

    /**
     * @param array{model:string,file_path:string,filename:string,mime:string} $payload
     */
    public function audioTranscribe(array $payload): array
    {
        $bytes = @file_get_contents($payload['file_path']);
        if ($bytes === false) {
            throw new RuntimeException('Failed to read audio file for transcription.');
        }

        $resp = $this->client()
            ->acceptJson()
            ->attach('file', $bytes, $payload['filename'])
            ->post('/v1/audio/transcriptions', [
                'model' => $payload['model'],
            ]);

        return $this->decodeJsonOrThrow($resp->status(), $resp->body());
    }

    /**
     * @param array{model:string,voice:string,input:string,format?:string,speed?:float|null} $payload
     */
    public function audioSpeech(array $payload): string
    {
        $format = $payload['format'] ?? 'mp3';
        $request = [
            'model' => $payload['model'],
            'voice' => $payload['voice'],
            'input' => $payload['input'],
            'format' => $format,
        ];

        if (isset($payload['speed']) && is_numeric($payload['speed'])) {
            $request['speed'] = max(0.7, min(1.6, (float) $payload['speed']));
        }

        $resp = $this->client()
            ->withHeaders(['Accept' => 'audio/mpeg'])
            ->post('/v1/audio/speech', $request);

        if ($resp->status() >= 400) {
            $decoded = json_decode($resp->body(), true);
            $msg = is_array($decoded) ? ($decoded['error']['message'] ?? null) : null;
            throw new RuntimeException('OpenAI error (HTTP '.$resp->status().'): '.($msg ?: 'request failed.'));
        }

        return (string) $resp->body();
    }

    private function json(string $method, string $path, array $payload): array
    {
        $resp = $this->client()
            ->acceptJson()
            ->withHeaders(['Content-Type' => 'application/json'])
            ->send($method, $path, [
                'json' => $payload,
            ]);

        return $this->decodeJsonOrThrow($resp->status(), $resp->body());
    }

    private function decodeJsonOrThrow(int $status, string $body): array
    {
        $decoded = json_decode($body, true);
        if (!is_array($decoded)) {
            throw new RuntimeException("OpenAI returned non-JSON response (HTTP {$status}).");
        }

        if ($status >= 400) {
            $msg = $decoded['error']['message'] ?? 'OpenAI request failed.';
            throw new RuntimeException("OpenAI error (HTTP {$status}): {$msg}");
        }

        return $decoded;
    }

    private function client(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->withToken($this->apiKey)
            ->timeout($this->timeoutSeconds)
            ->connectTimeout(10)
            ->retry(1, 200);
    }
}
