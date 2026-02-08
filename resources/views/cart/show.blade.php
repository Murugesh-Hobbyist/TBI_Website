@extends('layouts.site')

@section('title', 'Cart | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <h1 class="font-display text-4xl tracking-tight">Cart</h1>

        <div class="mt-8 grid gap-6 md:grid-cols-3">
            <div class="md:col-span-2 space-y-4">
                @forelse ($items as $item)
                    <div class="card p-6">
                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <div class="font-semibold">{{ $item['product']->title }}</div>
                                <div class="mt-1 text-sm text-white/60">
                                    Qty: {{ $item['qty'] }}
                                    @if ($item['product']->sku)
                                        · SKU: {{ $item['product']->sku }}
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-white/60">Line total</div>
                                <div class="mt-1 font-semibold">
                                    {{ $currency }} {{ number_format(((int) $item['line_total_cents']) / 100, 2) }}
                                </div>
                                <form method="POST" action="{{ route('cart.remove', $item['product']) }}" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-xs text-white/70 hover:text-white">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card p-6 text-sm text-white/70">
                        Cart is empty. Browse <a class="underline hover:text-white" href="{{ route('products.index') }}">products</a>.
                    </div>
                @endforelse
            </div>

            <div class="card p-6">
                <div class="text-sm text-white/60">Subtotal</div>
                <div class="mt-2 font-display text-3xl">
                    {{ $currency }} {{ number_format(((int) $subtotalCents) / 100, 2) }}
                </div>

                <div class="mt-6 border-t border-white/10 pt-6">
                    <div class="font-semibold">Checkout</div>
                    <p class="mt-2 text-sm text-white/60">Phase 1: order request without payment integration.</p>

                    <form class="mt-4 grid gap-3" method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <input name="name" placeholder="Name" class="w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
                        <input name="email" type="email" placeholder="Email (optional)" class="w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
                        <input name="phone" placeholder="Phone (optional)" class="w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
                        <textarea name="notes" rows="3" placeholder="Notes (optional)" class="w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40"></textarea>
                        <button class="btn btn-primary" type="submit" @if (count($items)===0) disabled @endif>Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

