@extends('layouts.site')

@section('title', 'Pricing - '.config('twinbot.site.domain'))
@section('meta_description', 'Competitive pricing for embedded automation solutions. Replace costly PLC systems with ECS.')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">Pricing</h1>
            <p class="mt-3 max-w-3xl text-sm text-[#364151]">
                Our pricing strategy is designed to provide exceptional value without compromising quality.
                By replacing costly PLC systems with embedded control systems, we help you achieve significant savings while maintaining high performance.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('contact') }}" class="btn btn-primary">Request a Quote</a>
                <a href="{{ route('products.index') }}" class="btn btn-ghost">Browse Products</a>
            </div>
        </div>
    </section>

    <section class="mx-auto mt-8 max-w-6xl px-4">
        <div class="grid gap-4 md:grid-cols-3">
            @foreach ([
                ['t' => 'Customizable Packages', 'd' => 'Choose features that align with your requirements and ROI targets.'],
                ['t' => 'Cost and Maintenance', 'd' => 'Lower total cost of ownership with affordable spares and simpler maintenance.'],
                ['t' => 'Beyond PLC Limits', 'd' => 'Data logging and analytics at a price that is typically expensive with PLC systems.'],
            ] as $c)
                <div class="rounded-3xl border border-black/10 bg-white p-6">
                    <div class="font-display text-xl text-[#0F172A]">{{ $c['t'] }}</div>
                    <div class="mt-2 text-sm text-[#364151]">{{ $c['d'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto mt-8 max-w-6xl px-4 pb-16">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
            <h2 class="font-display text-2xl text-[#0F172A]">Enjoy these features on all plans</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['t' => 'Support', 'd' => 'Our support team is available to assist and resolve issues promptly.'],
                    ['t' => 'Durable Solutions', 'd' => 'Reliable hardware designed for industrial environments.'],
                    ['t' => 'Scalable', 'd' => 'Scale with your business needs without compromising performance.'],
                    ['t' => 'Enclosure', 'd' => 'Secure enclosures (3D-printed / sheet metal) for protection and security.'],
                    ['t' => 'Protection', 'd' => 'Options for water and dust protection to improve longevity.'],
                    ['t' => 'Transparent Value', 'd' => 'Competitive rates compared to other automation solution providers.'],
                ] as $f)
                    <div class="rounded-2xl border border-black/10 bg-[#E7F6FF] p-5">
                        <div class="font-semibold text-[#0F172A]">{{ $f['t'] }}</div>
                        <div class="mt-1 text-sm text-[#364151]">{{ $f['d'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

