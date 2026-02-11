<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = collect();

        try {
            $products = Product::query()
                ->where('is_published', true)
                ->with('media')
                ->latest()
                ->get()
                ->map(function (Product $p) {
                    return $this->normalizeProduct($p);
                })
                ->values();
        } catch (\Throwable $e) {
            $products = collect($this->fallbackProducts())->values();
        }

        return view('products.index', [
            'products' => $products,
            'groups' => config('twinbot.product_groups', []),
        ]);
    }

    public function show(string $product)
    {
        $normalized = null;

        try {
            $p = Product::query()->where('slug', $product)->firstOrFail();
            abort_unless($p->is_published, 404);
            $p->load('media');
            $normalized = $this->normalizeProduct($p);
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            $normalized = $this->fallbackProductBySlug($product);
            if (!$normalized) {
                abort(404);
            }
        }

        return view('products.show', [
            'product' => $normalized,
        ]);
    }

    public function enquiry(Request $request, string $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:5000'],
        ]);

        $productInfo = $this->fallbackProductBySlug($product);
        try {
            $p = Product::query()->where('slug', $product)->first();
            if ($p) {
                $productInfo = array_merge($productInfo ?? [], $this->normalizeProduct($p));
            }
        } catch (\Throwable $e) {
            // ignore
        }

        $data['type'] = 'product_enquiry';
        $data['meta'] = [
            'product_slug' => $product,
            'product_title' => $productInfo['title'] ?? null,
            'ip' => $request->ip(),
            'ua' => Str::limit((string) $request->userAgent(), 512, '...'),
        ];

        try {
            Lead::create($data);
        } catch (\Throwable $e) {
            return redirect()->route('products.show', ['product' => $product])
                ->with('status', 'Thanks. Enquiry received (database setup pending).');
        }

        return redirect()->route('products.show', ['product' => $product])
            ->with('status', 'Thanks. We will get back to you shortly.');
    }

    private function fallbackProducts(): array
    {
        return (array) config('twinbot.products', []);
    }

    private function fallbackProductBySlug(string $slug): ?array
    {
        $all = $this->fallbackProducts();
        foreach ($all as $p) {
            if (($p['slug'] ?? null) === $slug) {
                return $p;
            }
        }

        return null;
    }

    private function normalizeProduct(Product $p): array
    {
        $image = null;
        $firstImage = $p->media->firstWhere('type', 'image');
        if ($firstImage && $firstImage->path) {
            $image = \Illuminate\Support\Facades\Storage::disk('public')->url($firstImage->path);
        }

        // If no media exists, use the fallback catalog image (if available).
        if (!$image) {
            $fallback = $this->fallbackProductBySlug((string) $p->slug);
            $image = $fallback['image'] ?? null;
        }

        return [
            'title' => (string) $p->title,
            'slug' => (string) $p->slug,
            'summary' => $p->summary ? (string) $p->summary : null,
            'body' => $p->body ? (string) $p->body : null,
            'sku' => $p->sku ? (string) $p->sku : null,
            'price_cents' => (int) $p->price_cents,
            'currency' => (string) $p->currency,
            'image' => $image,
        ];
    }
}
