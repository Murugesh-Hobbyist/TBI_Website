@extends('layouts.site')

@section('title', 'Cart | TwinBot Innovations')
@section('meta_description', 'Review enquiry cart and place your TwinBot order request.')

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Enquiry Cart</span>
                <h1 class="tb-heading mt-4">Prepare your order request.</h1>
                <p class="tb-lead mt-5 max-w-3xl">This is a quote-oriented cart flow without online payment. Submit your details and we will follow up with confirmation and next steps.</p>
            </div>

            <div class="grid gap-5 mt-5 md:grid-cols-3">
                <div class="space-y-4 md:col-span-2">
                    @forelse ($items as $item)
                        <article class="tb-card tb-reveal">
                            <div class="flex items-start justify-between gap-5">
                                <div>
                                    <h2 class="font-display text-xl text-[#112743]">{{ $item['product']->title }}</h2>
                                    <p class="mt-1 text-sm text-[#4C6686]">
                                        Qty: {{ $item['qty'] }}
                                        @if ($item['product']->sku)
                                            | SKU: {{ $item['product']->sku }}
                                        @endif
                                    </p>
                                </div>

                                <div class="text-right">
                                    <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#5B7698]">Line Total</div>
                                    <div class="mt-1 font-display text-xl text-[#173D68]">{{ $currency }} {{ number_format(((int) $item['line_total_cents']) / 100, 2) }}</div>
                                    <form method="POST" action="{{ route('cart.remove', $item['product']) }}" class="mt-3">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-[#0B6ECD] hover:text-[#0957A6]">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="tb-panel p-6 text-sm text-[#4C6686] tb-reveal">
                            Cart is empty. Browse <a class="font-semibold text-[#0B6ECD] hover:text-[#0957A6]" href="{{ route('products.index') }}">products</a>.
                        </div>
                    @endforelse
                </div>

                <aside class="tb-panel p-6 tb-reveal">
                    <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#5B7698]">Subtotal</div>
                    <div class="mt-2 font-display text-4xl text-[#173D68]">{{ $currency }} {{ number_format(((int) $subtotalCents) / 100, 2) }}</div>

                    <div class="mt-6 border-t border-[#D1E0EE] pt-6">
                        <h2 class="font-display text-2xl text-[#112743]">Checkout Request</h2>
                        <p class="mt-2 text-sm text-[#4C6686]">Share contact details to submit your order request.</p>

                        <form class="mt-4 grid gap-3" method="POST" action="{{ route('cart.checkout') }}">
                            @csrf
                            <input name="name" placeholder="Name" class="tb-input" required />
                            <input name="email" type="email" placeholder="Email (optional)" class="tb-input" />
                            <input name="phone" placeholder="Phone (optional)" class="tb-input" />
                            <textarea name="notes" rows="3" placeholder="Notes (optional)" class="tb-textarea"></textarea>
                            <button class="btn btn-primary" type="submit" @if (count($items)===0) disabled @endif>Place Order Request</button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
