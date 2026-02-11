@extends('layouts.site')

@section('title', 'Cart - '.config('twinbot.site.domain'))

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10 pb-16">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">Cart</h1>
            <p class="mt-3 max-w-3xl text-sm text-[#364151]">
                This cart is a basic order-request flow (no payment integration).
            </p>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-3">
            <div class="md:col-span-2 space-y-4">
                @forelse ($items as $item)
                    <div class="rounded-3xl border border-black/10 bg-white p-6">
                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <div class="font-semibold text-[#0F172A]">{{ $item['product']->title }}</div>
                                <div class="mt-1 text-sm text-[#364151]">
                                    Qty: {{ $item['qty'] }}
                                    @if ($item['product']->sku)
                                        - SKU: {{ $item['product']->sku }}
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-[#364151]">Line total</div>
                                <div class="mt-1 font-semibold text-[#0F172A]">
                                    {{ $currency }} {{ number_format(((int) $item['line_total_cents']) / 100, 2) }}
                                </div>
                                <form method="POST" action="{{ route('cart.remove', $item['product']) }}" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold text-[#0067FF] hover:text-[#005EE9]">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-black/10 bg-white p-6 text-sm text-[#364151]">
                        Cart is empty. Browse <a class="font-semibold text-[#0067FF] hover:text-[#005EE9]" href="{{ route('products.index') }}">products</a>.
                    </div>
                @endforelse
            </div>

            <div class="rounded-3xl border border-black/10 bg-white p-6">
                <div class="text-sm text-[#364151]">Subtotal</div>
                <div class="mt-2 font-display text-3xl text-[#0F172A]">
                    {{ $currency }} {{ number_format(((int) $subtotalCents) / 100, 2) }}
                </div>

                <div class="mt-6 border-t border-black/10 pt-6">
                    <div class="font-semibold text-[#0F172A]">Checkout</div>
                    <p class="mt-2 text-sm text-[#364151]">Order request without payment integration.</p>

                    <form class="mt-4 grid gap-3" method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <input name="name" placeholder="Name" class="w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] placeholder:text-[#364151]/60 focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" required />
                        <input name="email" type="email" placeholder="Email (optional)" class="w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] placeholder:text-[#364151]/60 focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" />
                        <input name="phone" placeholder="Phone (optional)" class="w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] placeholder:text-[#364151]/60 focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" />
                        <textarea name="notes" rows="3" placeholder="Notes (optional)" class="w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] placeholder:text-[#364151]/60 focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30"></textarea>
                        <button class="btn btn-primary" type="submit" @if (count($items)===0) disabled @endif>Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

