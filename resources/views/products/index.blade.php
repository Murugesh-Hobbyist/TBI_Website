@extends('layouts.site')

@section('title', 'Products - '.config('twinbot.site.domain'))
@section('meta_description', 'Explore DigiDial and FitSense product series from TwinBot Innovations.')

@section('content')
    @php
        $bySlug = collect($products ?? [])->keyBy('slug');
    @endphp

    <section class="mx-auto max-w-6xl px-4 pt-10">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">Products</h1>
            <p class="mt-3 max-w-3xl text-sm text-[#364151]">
                Measurement, inspection, and embedded automation products built for reliability, usability, and modern integration.
            </p>
        </div>
    </section>

    <section class="mx-auto mt-8 max-w-6xl px-4 pb-16">
        @foreach (($groups ?? []) as $g)
            @php
                $items = collect($g['slugs'] ?? [])
                    ->map(fn ($slug) => $bySlug->get($slug))
                    ->filter()
                    ->values();
            @endphp

            @continue($items->count() === 0)

            <div class="mt-8 first:mt-0">
                <h2 class="font-display text-2xl text-[#0F172A]">{{ $g['title'] ?? 'Products' }}</h2>

                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    @foreach ($items as $p)
                        @php
                            $img = $p['image'] ?? null;
                            $src = $img && \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : ($img ? asset($img) : null);
                        @endphp
                        <a href="{{ route('products.show', ['product' => $p['slug']]) }}" class="group overflow-hidden rounded-2xl border border-black/10 bg-white hover:bg-[#E7F6FF]">
                            @if ($src)
                                <div class="h-48 w-full bg-white">
                                    <img src="{{ $src }}" alt="" class="h-full w-full object-contain p-5 transition-transform duration-200 group-hover:scale-[1.02]" />
                                </div>
                            @endif
                            <div class="px-5 pb-5 pt-4">
                                <div class="text-xs font-semibold text-[#364151]">{{ $p['series'] ?? '' }}</div>
                                <div class="mt-1 font-semibold text-[#0F172A]">{{ $p['title'] }}</div>
                                @if (!empty($p['summary']))
                                    <div class="mt-2 text-sm text-[#364151]">{{ \Illuminate\Support\Str::limit(strip_tags((string) $p['summary']), 140) }}</div>
                                @endif
                                <div class="mt-3 text-sm font-semibold text-[#0067FF]">Read more</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if (($products ?? collect())->count() === 0)
            <div class="mt-8 rounded-3xl border border-black/10 bg-white p-6 text-sm text-[#364151]">
                No products available.
            </div>
        @endif
    </section>
@endsection

