<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private const CART_KEY = 'cart.items';

    public function show(Request $request)
    {
        [$items, $subtotalCents] = $this->cartSummary($request);

        return view('cart.show', [
            'items' => $items,
            'subtotalCents' => $subtotalCents,
            'currency' => 'INR',
        ]);
    }

    public function add(Request $request, string $product)
    {
        try {
            $product = Product::query()->where('is_published', true)->findOrFail((int) $product);
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            return redirect()->route('cart.show')->with('status', 'Cart is unavailable until database is configured.');
        }

        $qty = (int) ($request->input('qty', 1));
        $qty = max(1, min(99, $qty));

        $cart = $request->session()->get(self::CART_KEY, []);
        $cart[(string) $product->id] = ($cart[(string) $product->id] ?? 0) + $qty;
        $request->session()->put(self::CART_KEY, $cart);

        return redirect()->route('cart.show')->with('status', 'Added to cart.');
    }

    public function remove(Request $request, string $product)
    {
        $cart = $request->session()->get(self::CART_KEY, []);
        unset($cart[(string) ((int) $product)]);
        $request->session()->put(self::CART_KEY, $cart);

        return redirect()->route('cart.show')->with('status', 'Removed from cart.');
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        [$items, $subtotalCents] = $this->cartSummary($request);
        if (count($items) === 0) {
            return redirect()->route('cart.show')->with('status', 'Cart is empty.');
        }

        try {
            $orderId = DB::transaction(function () use ($items, $subtotalCents, $data) {
                $order = Order::create([
                    'status' => 'pending',
                    'customer_name' => $data['name'],
                    'customer_email' => $data['email'] ?? null,
                    'customer_phone' => $data['phone'] ?? null,
                    'subtotal_cents' => $subtotalCents,
                    'currency' => 'INR',
                    'notes' => $data['notes'] ?? null,
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'title' => $item['product']->title,
                        'sku' => $item['product']->sku,
                        'qty' => $item['qty'],
                        'unit_price_cents' => $item['unit_price_cents'],
                        'line_total_cents' => $item['line_total_cents'],
                    ]);
                }

                return $order->id;
            });
        } catch (\Throwable $e) {
            return redirect()->route('cart.show')->with('status', 'Checkout is unavailable until database is configured.');
        }

        $request->session()->forget(self::CART_KEY);

        return redirect()->route('cart.show')->with('status', "Order received. Reference: #{$orderId} (payment integration pending).");
    }

    private function cartSummary(Request $request): array
    {
        $cart = $request->session()->get(self::CART_KEY, []);
        $productIds = array_map('intval', array_keys($cart));

        try {
            $products = Product::query()
                ->whereIn('id', $productIds)
                ->where('is_published', true)
                ->get()
                ->keyBy('id');
        } catch (\Throwable $e) {
            return [[], 0];
        }

        $items = [];
        $subtotalCents = 0;

        foreach ($cart as $productId => $qty) {
            $product = $products->get((int) $productId);
            if (!$product) {
                continue;
            }

            $qty = max(1, min(99, (int) $qty));
            $unit = (int) $product->price_cents;
            $line = $unit * $qty;
            $subtotalCents += $line;

            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'unit_price_cents' => $unit,
                'line_total_cents' => $line,
            ];
        }

        return [$items, $subtotalCents];
    }
}
