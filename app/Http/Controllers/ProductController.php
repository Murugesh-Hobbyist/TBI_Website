<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
    public function index()
    {
        $dbOk = true;

        try {
            $products = Product::query()
                ->where('is_published', true)
                ->latest()
                ->paginate(12);
        } catch (\Throwable $e) {
            $dbOk = false;
            $products = new LengthAwarePaginator([], 0, 12, 1, [
                'path' => Paginator::resolveCurrentPath(),
            ]);
        }

        return view('products.index', [
            'products' => $products,
            'dbOk' => $dbOk,
        ]);
    }

    public function show(string $product)
    {
        try {
            $product = Product::query()->where('slug', $product)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(503, 'Database not configured.');
        }

        abort_unless($product->is_published, 404);

        $product->load('media');

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
