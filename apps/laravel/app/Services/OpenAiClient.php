<?php

namespace App\Services;

use RuntimeException;

class OpenAiClient
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = (string) config('assistant.openai_api_key');
        $this->baseUrl = rtrim((string) config('assistant.base_url'), '/');

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
        $fields = [
            'model' => $payload['model'],
            'file' => new \CURLFile($payload['file_path'], $payload['mime'], $payload['filename']),
        ];

        return $this->multipart('POST', '/v1/audio/transcriptions', $fields);
    }

    /**
     * @param array{model:string,voice:string,input:string,format?:string} $payload
     */
    public function audioSpeech(array $payload): string
    {
        $format = $payload['format'] ?? 'mp3';

        $resp = $this->raw('POST', '/v1/audio/speech', [
            'model' => $payload['model'],
            'voice' => $payload['voice'],
            'input' => $payload['input'],
            'format' => $format,
        ], [
            'Accept: audio/mpeg',
        ]);

        return $resp['body'];
    }

    private function json(string $method, string $path, array $payload): array
    {
        $resp = $this->raw($method, $path, $payload, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $decoded = json_decode($resp['body'], true);
        if (!is_array($decoded)) {
            throw new RuntimeException("OpenAI returned non-JSON response (HTTP {$resp['status']}).");
        }

        if ($resp['status'] >= 400) {
            $msg = $decoded['error']['message'] ?? 'OpenAI request failed.';
            throw new RuntimeException("OpenAI error (HTTP {$resp['status']}): {$msg}");
        }

        return $decoded;
    }

    private function multipart(string $method, string $path, array $fields): array
    {
        $resp = $this->rawMultipart($method, $path, $fields, [
            'Accept: application/json',
        ]);

        $decoded = json_decode($resp['body'], true);
        if (!is_array($decoded)) {
            throw new RuntimeException("OpenAI returned non-JSON response (HTTP {$resp['status']}).");
        }

        if ($resp['status'] >= 400) {
            $msg = $decoded['error']['message'] ?? 'OpenAI request failed.';
            throw new RuntimeException("OpenAI error (HTTP {$resp['status']}): {$msg}");
        }

        return $decoded;
    }

    /**
     * @return array{status:int,body:string}
     */
    private function raw(string $method, string $path, array $jsonPayload, array $extraHeaders = []): array
    {
        $url = $this->baseUrl.$path;

        $ch = curl_init($url);
        if ($ch === false) {
            throw new RuntimeException('Failed to init curl');
        }

        $headers = array_merge([
            'Authorization: Bearer '.$this->apiKey,
        ], $extraHeaders);

        $body = json_encode($jsonPayload);
        if ($body === false) {
            throw new RuntimeException('Failed to encode JSON payload');
        }

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_TIMEOUT => (int) config('assistant.timeout_seconds'),
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $respBody = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($respBody === false) {
            throw new RuntimeException('Curl error: '.$err);
        }

        return ['status' => $status, 'body' => (string) $respBody];
    }

    /**
     * @return array{status:int,body:string}
     */
    private function rawMultipart(string $method, string $path, array $fields, array $extraHeaders = []): array
    {
        $url = $this->baseUrl.$path;

        $ch = curl_init($url);
        if ($ch === false) {
            throw new RuntimeException('Failed to init curl');
        }

        $headers = array_merge([
            'Authorization: Bearer '.$this->apiKey,
        ], $extraHeaders);

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_TIMEOUT => (int) config('assistant.timeout_seconds'),
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $respBody = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($respBody === false) {
            throw new RuntimeException('Curl error: '.$err);
        }

        return ['status' => $status, 'body' => (string) $respBody];
    }
}

