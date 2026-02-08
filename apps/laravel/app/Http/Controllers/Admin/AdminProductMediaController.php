<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductMediaController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'max:40'],
            'title' => ['nullable', 'string', 'max:255'],
            'external_url' => ['nullable', 'string', 'max:2048'],
            'file' => ['nullable', 'file', 'max:10240'], // 10MB
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store("products/{$product->id}", 'public');
        }

        ProductMedia::create([
            'product_id' => $product->id,
            'type' => $data['type'],
            'title' => $data['title'] ?? null,
            'path' => $path,
            'external_url' => $data['external_url'] ?? null,
            'sort_order' => 0,
        ]);

        return redirect()->route('admin.products.edit', $product)->with('status', 'Media added.');
    }

    public function destroy(ProductMedia $media)
    {
        $productId = $media->product_id;
        $path = $media->path;
        $media->delete();

        if ($path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()->route('admin.products.edit', $productId)->with('status', 'Media removed.');
    }
}

