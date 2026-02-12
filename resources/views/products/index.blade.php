@extends('layouts.site')

@section('title', 'Products | TwinBot Innovations')
@section('meta_description', 'Explore TwinBot product lines including DigiDial consoles, FitSense systems, and industrial measurement accessories.')

@section('content')
    @php
        $bySlug = collect($products ?? [])->keyBy('slug');
    @endphp

    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Product Portfolio</span>
                <h1 class="tb-heading mt-4">Tools and systems designed for precision-driven industrial teams.</h1>
                <p class="tb-lead mt-5 max-w-3xl">From dimensional inspection consoles to displacement measurement platforms, each product is built for consistent shop-floor performance and simple operator workflows.</p>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="mx-auto max-w-6xl px-4">
            @foreach (($groups ?? []) as $group)
                @php
                    $items = collect($group['slugs'] ?? [])->map(fn ($slug) => $bySlug->get($slug))->filter()->values();
                @endphp

                @continue($items->count() === 0)

                <div class="tb-panel p-6 md:p-8 mt-5 first:mt-0 tb-reveal">
                    <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                        <div>
                            <span class="tb-eyebrow">Series</span>
                            <h2 class="tb-subheading mt-3">{{ $group['title'] ?? 'Products' }}</h2>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        @foreach ($items as $product)
                            @php
                                $img = $product['image'] ?? null;
                                $src = $img && \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : ($img ? asset($img) : null);
                            @endphp
                            <a href="{{ route('products.show', ['product' => $product['slug']]) }}" class="tb-card group">
                                @if ($src)
                                    <div class="tb-product-thumb">
                                        <img src="{{ $src }}" alt="{{ $product['title'] }}" class="h-full w-full object-contain transition duration-200 group-hover:scale-[1.03]" />
                                    </div>
                                @endif
                                <div class="mt-4 text-xs font-extrabold uppercase tracking-[0.12em] text-[#597696]">{{ $product['series'] ?? 'Product' }}</div>
                                <div class="mt-2 font-display text-xl text-[#112743]">{{ $product['title'] }}</div>
                                @if (!empty($product['summary']))
                                    <p class="mt-2 text-sm leading-relaxed text-[#4C6686]">{{ \Illuminate\Support\Str::limit(strip_tags((string) $product['summary']), 150) }}</p>
                                @endif
                                <div class="mt-4 text-sm font-bold text-[#0B6ECD]">View product details</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if (($products ?? collect())->count() === 0)
                <div class="tb-panel p-6 text-sm text-[#4C6686] tb-reveal">No products available right now.</div>
            @endif

            <div class="tb-cta mt-6 tb-reveal">
                <span class="tb-eyebrow">Need help choosing?</span>
                <h2 class="tb-subheading mt-3">Tell us your application and we will recommend the right setup.</h2>
                <p class="tb-lead mt-3 max-w-2xl">Share channel count, measurement objective, and process environment. We will suggest the best-fit configuration.</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Get Product Guidance</a>
                    <a href="{{ route('solutions') }}" class="btn btn-ghost">See Full Solution Approach</a>
                </div>
            </div>
        </div>
    </section>
@endsection
