<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KbArticle;
use App\Models\Product;
use App\Models\Project;
use App\Models\Video;
use App\Services\OpenAiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssistantController extends Controller
{
    public function chat(Request $request, OpenAiClient $openai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
            'current_path' => ['nullable', 'string', 'max:255'],
            'current_title' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $query = trim($data['message']);
            $navigationAction = $this->detectNavigationAction($query);
            $context = $this->buildContext(
                $query,
                $data['current_path'] ?? null,
                $data['current_title'] ?? null
            );

            $instructions = trim((string) config('assistant.system_prompt'));
            if ($navigationAction) {
                $instructions .= "\n- User asked to navigate. Confirm destination briefly and continue helping.";
            }

            $resp = $openai->responsesCreate([
                'model' => (string) config('assistant.chat_model'),
                'input' => [
                    [
                        'role' => 'system',
                        'content' => [
                            ['type' => 'input_text', 'text' => $instructions],
                        ],
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            ['type' => 'input_text', 'text' => "User message:\n{$query}\n\nContext (website + published content):\n{$context}"],
                        ],
                    ],
                ],
            ]);

            $text = trim((string) ($resp['output_text'] ?? $this->extractText($resp)));
            if ($text === '' && $navigationAction) {
                $text = 'Opening '.$navigationAction['label'].' now.';
            }

            return response()->json([
                'ok' => true,
                'text' => $text,
                'action' => $navigationAction,
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

    private function buildContext(string $query, ?string $currentPath, ?string $currentTitle): string
    {
        $terms = $this->extractTerms($query);
        $q = Str::of($query)->lower()->limit(2000)->toString();
        $projects = collect();
        $products = collect();
        $videos = collect();
        $kb = collect();
        $dbUnavailable = false;

        try {
            $projects = Project::query()
                ->where('is_published', true)
                ->when($terms !== [], function ($builder) use ($terms) {
                    $this->applySearchFilters($builder, $terms, ['title', 'summary', 'body']);
                })
                ->latest('published_at')
                ->limit(5)
                ->get(['title', 'slug', 'summary']);
            if ($projects->isEmpty()) {
                $projects = Project::query()
                    ->where('is_published', true)
                    ->latest('published_at')
                    ->limit(3)
                    ->get(['title', 'slug', 'summary']);
            }

            $products = Product::query()
                ->where('is_published', true)
                ->when($terms !== [], function ($builder) use ($terms) {
                    $this->applySearchFilters($builder, $terms, ['title', 'summary', 'body', 'sku']);
                })
                ->latest()
                ->limit(6)
                ->get(['title', 'slug', 'summary', 'price_cents', 'currency', 'sku']);
            if ($products->isEmpty()) {
                $products = Product::query()
                    ->where('is_published', true)
                    ->latest()
                    ->limit(4)
                    ->get(['title', 'slug', 'summary', 'price_cents', 'currency', 'sku']);
            }

            $videos = Video::query()
                ->where('is_published', true)
                ->when($terms !== [], function ($builder) use ($terms) {
                    $this->applySearchFilters($builder, $terms, ['title', 'summary']);
                })
                ->latest('published_at')
                ->limit(4)
                ->get(['title', 'slug', 'summary']);
            if ($videos->isEmpty()) {
                $videos = Video::query()
                    ->where('is_published', true)
                    ->latest('published_at')
                    ->limit(3)
                    ->get(['title', 'slug', 'summary']);
            }

            $kb = KbArticle::query()
                ->where('is_published', true)
                ->when($terms !== [], function ($builder) use ($terms) {
                    $this->applySearchFilters($builder, $terms, ['title', 'body', 'tags']);
                })
                ->latest()
                ->limit(8)
                ->get(['title', 'slug', 'body', 'tags']);
            if ($kb->isEmpty()) {
                $kb = KbArticle::query()
                    ->where('is_published', true)
                    ->latest()
                    ->limit(4)
                    ->get(['title', 'slug', 'body', 'tags']);
            }
        } catch (\Throwable $e) {
            $dbUnavailable = true;
        }

        $fallbackProducts = collect(config('twinbot.products', []))
            ->filter(fn ($item) => is_array($item))
            ->values()
            ->take(6);

        $lines = [];
        $lines[] = "Website Profile:";
        $lines[] = "- Name: ".config('twinbot.site.name');
        $lines[] = "- Domain: ".config('twinbot.site.domain');
        $lines[] = "- Tagline: ".config('twinbot.site.tagline');
        $lines[] = "- Primary email: ".config('twinbot.contact.email_primary');
        $lines[] = "- Primary phone: ".config('twinbot.contact.phone_display');
        $lines[] = "- WhatsApp: ".config('twinbot.contact.whatsapp_url');
        $lines[] = "- Location: ".config('twinbot.contact.location');
        if ($dbUnavailable) {
            $lines[] = "- Published database content unavailable on this environment; using static site data.";
        }
        if ($currentPath) {
            $lines[] = "- Current page path: {$currentPath}";
        }
        if ($currentTitle) {
            $lines[] = "- Current page title: {$currentTitle}";
        }
        $lines[] = "";
        $lines[] = "Website Navigation:";
        foreach ($this->navigationCatalog() as $page) {
            $lines[] = "- {$page['label']} (".route($page['route'])."): {$page['description']}";
        }

        $lines[] = "";
        $lines[] = "Projects:";
        foreach ($projects as $p) {
            $lines[] = "- {$p->title} (".route('projects.show', ['project' => $p->slug]).")";
            if ($p->summary) {
                $lines[] = "  Summary: ".Str::limit(strip_tags((string) $p->summary), 280);
            }
        }
        if ($projects->isEmpty()) {
            $lines[] = "- No published projects available in this environment.";
        }

        $lines[] = "";
        $lines[] = "Products:";
        foreach ($products as $p) {
            $price = number_format(((int) $p->price_cents) / 100, 2);
            $sku = $p->sku ? " SKU: {$p->sku}" : '';
            $lines[] = "- {$p->title} (".route('products.show', ['product' => $p->slug]).") {$p->currency} {$price}{$sku}";
            if ($p->summary) {
                $lines[] = "  Summary: ".Str::limit(strip_tags((string) $p->summary), 280);
            }
        }
        if ($products->isEmpty() && $fallbackProducts->isNotEmpty()) {
            foreach ($fallbackProducts as $p) {
                $slug = (string) ($p['slug'] ?? '');
                $title = (string) ($p['title'] ?? '');
                if ($slug === '' || $title === '') {
                    continue;
                }
                $lines[] = "- {$title} (".route('products.show', ['product' => $slug]).")";
                if (!empty($p['summary'])) {
                    $lines[] = "  Summary: ".Str::limit(strip_tags((string) $p['summary']), 280);
                }
            }
        }
        if ($products->isEmpty() && $fallbackProducts->isEmpty()) {
            $lines[] = "- Product catalog currently unavailable.";
        }

        $lines[] = "";
        $lines[] = "Videos:";
        foreach ($videos as $video) {
            $lines[] = "- {$video->title} (".route('videos.show', ['video' => $video->slug]).")";
            if ($video->summary) {
                $lines[] = "  Summary: ".Str::limit(strip_tags((string) $video->summary), 260);
            }
        }
        if ($videos->isEmpty()) {
            $lines[] = "- No published videos available in this environment.";
        }

        $lines[] = "";
        $lines[] = "Knowledge Base Highlights:";
        foreach ($kb as $a) {
            $lines[] = "- {$a->title} (tags: ".($a->tags ?: 'n/a').")";
            $lines[] = "  ".Str::limit(strip_tags((string) $a->body), 480);
        }
        if ($kb->isEmpty()) {
            $lines[] = "- Knowledge base articles are currently unavailable in this environment.";
        }

        $faqs = config('twinbot.faqs', []);
        if (is_array($faqs) && $faqs !== []) {
            $lines[] = "";
            $lines[] = "FAQ Snapshots:";
            foreach (array_slice($faqs, 0, 6) as $faq) {
                if (!is_array($faq)) {
                    continue;
                }
                $qText = trim((string) ($faq['q'] ?? ''));
                $aText = trim((string) ($faq['a'] ?? ''));
                if ($qText === '' || $aText === '') {
                    continue;
                }
                $lines[] = "- Q: ".Str::limit($qText, 140);
                $lines[] = "  A: ".Str::limit($aText, 220);
            }
        }

        if ($q !== '') {
            $lines[] = "";
            $lines[] = "User query (lowercase): {$q}";
        }

        return trim(implode("\n", $lines));
    }

    private function detectNavigationAction(string $query): ?array
    {
        $normalized = Str::of($query)->lower()->squish()->toString();
        if ($normalized === '') {
            return null;
        }

        $navigationIntents = [
            'go to',
            'goto',
            'open',
            'navigate',
            'switch to',
            'move to',
            'take me',
            'bring me',
            'visit',
            'redirect',
            'jump to',
            'show me',
        ];

        if (!Str::contains($normalized, $navigationIntents)) {
            return null;
        }

        foreach ($this->navigationCatalog() as $page) {
            if (Str::contains($normalized, $page['keywords'])) {
                return [
                    'type' => 'navigate',
                    'label' => $page['label'],
                    'route' => $page['route'],
                    'url' => route($page['route']),
                ];
            }
        }

        return $this->resolveSpecificContentNavigation($normalized);
    }

    private function resolveSpecificContentNavigation(string $query): ?array
    {
        if (Str::contains($query, ['product', 'item', 'catalog'])) {
            $products = collect();
            try {
                $products = Product::query()
                    ->where('is_published', true)
                    ->latest()
                    ->limit(60)
                    ->get(['title', 'slug']);
            } catch (\Throwable $e) {
                $products = collect();
            }

            foreach ($products as $product) {
                $title = Str::lower($product->title);
                $slug = Str::lower($product->slug);
                $slugWords = str_replace('-', ' ', $slug);
                if (Str::contains($query, [$title, $slug, $slugWords])) {
                    return [
                        'type' => 'navigate',
                        'label' => $product->title,
                        'route' => 'products.show',
                        'url' => route('products.show', ['product' => $product->slug]),
                    ];
                }
            }

            if ($products->isEmpty()) {
                $fallbackProducts = collect(config('twinbot.products', []))
                    ->filter(fn ($item) => is_array($item))
                    ->values();

                foreach ($fallbackProducts as $product) {
                    $title = Str::lower((string) ($product['title'] ?? ''));
                    $slug = Str::lower((string) ($product['slug'] ?? ''));
                    $slugWords = str_replace('-', ' ', $slug);
                    if ($title === '' || $slug === '') {
                        continue;
                    }

                    if (Str::contains($query, [$title, $slug, $slugWords])) {
                        return [
                            'type' => 'navigate',
                            'label' => (string) $product['title'],
                            'route' => 'products.show',
                            'url' => route('products.show', ['product' => $product['slug']]),
                        ];
                    }
                }
            }
        }

        if (Str::contains($query, ['project', 'case study'])) {
            $projects = collect();
            try {
                $projects = Project::query()
                    ->where('is_published', true)
                    ->latest('published_at')
                    ->limit(60)
                    ->get(['title', 'slug']);
            } catch (\Throwable $e) {
                $projects = collect();
            }

            foreach ($projects as $project) {
                $title = Str::lower($project->title);
                $slug = Str::lower($project->slug);
                $slugWords = str_replace('-', ' ', $slug);
                if (Str::contains($query, [$title, $slug, $slugWords])) {
                    return [
                        'type' => 'navigate',
                        'label' => $project->title,
                        'route' => 'projects.show',
                        'url' => route('projects.show', ['project' => $project->slug]),
                    ];
                }
            }
        }

        if (Str::contains($query, ['video', 'demo'])) {
            $videos = collect();
            try {
                $videos = Video::query()
                    ->where('is_published', true)
                    ->latest('published_at')
                    ->limit(60)
                    ->get(['title', 'slug']);
            } catch (\Throwable $e) {
                $videos = collect();
            }

            foreach ($videos as $video) {
                $title = Str::lower($video->title);
                $slug = Str::lower($video->slug);
                $slugWords = str_replace('-', ' ', $slug);
                if (Str::contains($query, [$title, $slug, $slugWords])) {
                    return [
                        'type' => 'navigate',
                        'label' => $video->title,
                        'route' => 'videos.show',
                        'url' => route('videos.show', ['video' => $video->slug]),
                    ];
                }
            }
        }

        return null;
    }

    private function navigationCatalog(): array
    {
        return [
            [
                'label' => 'Home',
                'route' => 'home',
                'description' => 'Main landing page with automation overview.',
                'keywords' => ['home', 'homepage', 'main page', 'landing page'],
            ],
            [
                'label' => 'Products',
                'route' => 'products.index',
                'description' => 'Product catalog with all industrial products.',
                'keywords' => ['product', 'products', 'catalog', 'shop', 'product page'],
            ],
            [
                'label' => 'Features',
                'route' => 'features',
                'description' => 'Feature breakdown and capability details.',
                'keywords' => ['feature', 'features', 'capabilities'],
            ],
            [
                'label' => 'Solutions',
                'route' => 'solutions',
                'description' => 'Industry solution positioning and architecture.',
                'keywords' => ['solution', 'solutions', 'architecture'],
            ],
            [
                'label' => 'Pricing',
                'route' => 'pricing',
                'description' => 'Commercial guidance and pricing options.',
                'keywords' => ['pricing', 'price', 'cost', 'quote cost'],
            ],
            [
                'label' => 'Projects',
                'route' => 'projects.index',
                'description' => 'Published project case studies.',
                'keywords' => ['project', 'projects', 'case study', 'portfolio'],
            ],
            [
                'label' => 'Videos',
                'route' => 'videos.index',
                'description' => 'Video demos and explainers.',
                'keywords' => ['video', 'videos', 'demo', 'youtube'],
            ],
            [
                'label' => 'About',
                'route' => 'about',
                'description' => 'Company background and mission.',
                'keywords' => ['about', 'company', 'team', 'who we are'],
            ],
            [
                'label' => 'Contact',
                'route' => 'contact',
                'description' => 'Contact form, phone, and email details.',
                'keywords' => ['contact', 'consultation', 'quote', 'talk to', 'call us'],
            ],
            [
                'label' => 'Forum',
                'route' => 'forum',
                'description' => 'Technical discussion and forum page.',
                'keywords' => ['forum', 'discussion', 'community'],
            ],
            [
                'label' => 'Cart',
                'route' => 'cart.show',
                'description' => 'Cart and checkout flow.',
                'keywords' => ['cart', 'checkout', 'order page'],
            ],
        ];
    }

    private function extractTerms(string $query): array
    {
        $cleaned = Str::of($query)
            ->lower()
            ->replaceMatches('/[^a-z0-9\s-]/', ' ')
            ->squish()
            ->toString();

        if ($cleaned === '') {
            return [];
        }

        $stopWords = [
            'the', 'and', 'for', 'with', 'that', 'this', 'from', 'have', 'what',
            'about', 'please', 'page', 'open', 'show', 'need', 'want', 'help',
            'into', 'over', 'your', 'ours', 'you', 'can', 'how', 'are', 'was',
            'were', 'will', 'just', 'tell', 'more', 'info',
        ];

        $parts = preg_split('/\s+/', $cleaned) ?: [];
        $filtered = array_values(array_filter($parts, function (string $term) use ($stopWords): bool {
            if (strlen($term) < 3) {
                return false;
            }

            return !in_array($term, $stopWords, true);
        }));

        return array_slice(array_values(array_unique($filtered)), 0, 8);
    }

    private function applySearchFilters($builder, array $terms, array $columns): void
    {
        if ($terms === [] || $columns === []) {
            return;
        }

        $builder->where(function ($query) use ($terms, $columns) {
            foreach ($terms as $term) {
                $like = '%'.$term.'%';
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', $like);
                }
            }
        });
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
                    $type = $c['type'] ?? null;
                    if (($type === 'output_text' || $type === 'summary_text') && isset($c['text'])) {
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
