<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', [
            'products' => Product::query()
                ->where('is_published', true)
                ->latest()
                ->paginate(12),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_published, 404);

        $product->load('media');

        return view('products.show', [
            'product' => $product,
        ]);
    }
}

