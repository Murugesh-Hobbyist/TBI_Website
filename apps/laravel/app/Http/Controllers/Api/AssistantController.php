<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KbArticle;
use App\Models\Product;
use App\Models\Project;
use App\Services\OpenAiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssistantController extends Controller
{
    public function chat(Request $request, OpenAiClient $openai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        try {
            $query = trim($data['message']);
            $context = $this->buildContext($query);

            $instructions = trim((string) config('assistant.system_prompt'));

            $resp = $openai->responsesCreate([
                'model' => (string) config('assistant.chat_model'),
                'input' => [
                    [
                        'role' => 'system',
                        'content' => [
                            ['type' => 'text', 'text' => $instructions],
                        ],
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            ['type' => 'text', 'text' => "User message:\n{$query}\n\nContext (site database):\n{$context}"],
                        ],
                    ],
                ],
            ]);

            return response()->json([
                'ok' => true,
                'text' => $resp['output_text'] ?? $this->extractText($resp),
                'raw' => config('assistant.debug_raw') ? $resp : null,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function transcribe(Request $request, OpenAiClient $openai)
    {
        try {
            $request->validate([
                'audio' => ['required', 'file', 'max:20480'], // 20MB
            ]);

            $file = $request->file('audio');

            $resp = $openai->audioTranscribe([
                'model' => (string) config('assistant.transcribe_model'),
                'file_path' => $file->getRealPath(),
                'filename' => $file->getClientOriginalName() ?: 'audio.webm',
                'mime' => $file->getMimeType() ?: 'application/octet-stream',
            ]);

            return response()->json([
                'ok' => true,
                'text' => (string) ($resp['text'] ?? ''),
                'raw' => config('assistant.debug_raw') ? $resp : null,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function speak(Request $request, OpenAiClient $openai)
    {
        try {
            $data = $request->validate([
                'text' => ['required', 'string', 'max:4000'],
                'voice' => ['nullable', 'string', 'max:64'],
            ]);

            $voice = $data['voice'] ?: (string) config('assistant.tts_voice');

            $audioBytes = $openai->audioSpeech([
                'model' => (string) config('assistant.tts_model'),
                'voice' => $voice,
                'input' => $data['text'],
                'format' => 'mp3',
            ]);

            return response($audioBytes, 200, [
                'Content-Type' => 'audio/mpeg',
                'Cache-Control' => 'no-store',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function buildContext(string $query): string
    {
        $q = Str::of($query)->lower()->limit(2000)->toString();

        $projects = Project::query()
            ->where('is_published', true)
            ->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%")
                    ->orWhere('body', 'like', "%{$q}%");
            })
            ->latest('published_at')
            ->limit(5)
            ->get(['title', 'slug', 'summary']);

        $products = Product::query()
            ->where('is_published', true)
            ->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%")
                    ->orWhere('body', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            })
            ->latest()
            ->limit(5)
            ->get(['title', 'slug', 'summary', 'price_cents', 'currency', 'sku']);

        $kb = KbArticle::query()
            ->where('is_published', true)
            ->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('body', 'like', "%{$q}%")
                    ->orWhere('tags', 'like', "%{$q}%");
            })
            ->latest()
            ->limit(8)
            ->get(['title', 'slug', 'body', 'tags']);

        $lines = [];
        $lines[] = "Projects:";
        foreach ($projects as $p) {
            $lines[] = "- {$p->title} (/projects/{$p->slug})";
            if ($p->summary) {
                $lines[] = "  Summary: ".Str::limit(strip_tags((string) $p->summary), 350);
            }
        }

        $lines[] = "";
        $lines[] = "Products:";
        foreach ($products as $p) {
            $price = number_format(((int) $p->price_cents) / 100, 2);
            $sku = $p->sku ? " SKU: {$p->sku}" : '';
            $lines[] = "- {$p->title} (/products/{$p->slug}) {$p->currency} {$price}{$sku}";
            if ($p->summary) {
                $lines[] = "  Summary: ".Str::limit(strip_tags((string) $p->summary), 350);
            }
        }

        $lines[] = "";
        $lines[] = "Knowledge Base:";
        foreach ($kb as $a) {
            $lines[] = "- {$a->title} (tags: ".($a->tags ?: 'n/a').")";
            $lines[] = "  ".Str::limit(strip_tags((string) $a->body), 600);
        }

        return trim(implode("\n", $lines));
    }

    private function extractText(array $resp): string
    {
        // Fallback for older/newer response shapes.
        if (isset($resp['output']) && is_array($resp['output'])) {
            $chunks = [];
            foreach ($resp['output'] as $item) {
                if (!is_array($item)) {
                    continue;
                }
                if (($item['type'] ?? null) !== 'message') {
                    continue;
                }
                foreach (($item['content'] ?? []) as $c) {
                    if (($c['type'] ?? null) === 'output_text' && isset($c['text'])) {
                        $chunks[] = (string) $c['text'];
                    }
                }
            }
            $text = trim(implode("\n", $chunks));
            if ($text !== '') {
                return $text;
            }
        }

        return '';
    }
}
