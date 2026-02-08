@extends('layouts.site')

@section('title', $product->title.' | Products | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <a href="{{ route('products.index') }}" class="text-sm text-white/70 hover:text-white">← Back to Products</a>
        <div class="mt-6 grid gap-8 md:grid-cols-2 md:items-start">
            <div class="card p-6">
                <div class="text-xs text-white/60">Product</div>
                <h1 class="mt-2 font-display text-4xl tracking-tight">{{ $product->title }}</h1>
                @if ($product->summary)
                    <p class="mt-4 text-white/70">{{ $product->summary }}</p>
                @endif
                <div class="mt-6 flex items-center justify-between rounded-xl border border-white/10 bg-black/20 px-4 py-3">
                    <div class="text-sm text-white/70">
                        @if ($product->sku)
                            SKU: <span class="text-white/90">{{ $product->sku }}</span>
                        @else
                            SKU: <span class="text-white/60">n/a</span>
                        @endif
                    </div>
                    <div class="text-lg font-semibold text-white">
                        {{ $product->currency }} {{ number_format(((int) $product->price_cents) / 100, 2) }}
                    </div>
                </div>

                <form class="mt-6 flex gap-3" method="POST" action="{{ route('cart.add', $product) }}">
                    @csrf
                    <input type="number" name="qty" value="1" min="1" max="99" class="w-24 rounded-xl border border-white/10 bg-black/20 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
                    <button class="btn btn-primary" type="submit">Add to Cart</button>
                    <a class="btn btn-ghost" href="{{ route('quote') }}">Request Quote</a>
                </form>
            </div>

            <div class="space-y-4">
                @if ($product->body)
                    <div class="card p-6">
                        <h2 class="font-display text-2xl">Details</h2>
                        <div class="mt-3 text-sm text-white/75 whitespace-pre-wrap">{{ $product->body }}</div>
                    </div>
                @endif

                @if ($product->media->count())
                    <div class="card p-6">
                        <h2 class="font-display text-2xl">Media</h2>
                        <div class="mt-4 grid gap-3 md:grid-cols-2">
                            @foreach ($product->media as $m)
                                <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                                    <div class="text-xs text-white/60">{{ strtoupper($m->type) }}</div>
                                    @if ($m->title)
                                        <div class="mt-1 font-semibold">{{ $m->title }}</div>
                                    @endif
                                    @if ($m->type === 'image' && $m->path)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($m->path) }}" alt="" class="mt-3 h-40 w-full rounded-lg object-cover" />
                                    @elseif ($m->external_url)
                                        <div class="mt-2 text-sm text-white/70 break-words">{{ $m->external_url }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

