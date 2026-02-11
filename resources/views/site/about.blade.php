@extends('layouts.site')

@section('title', 'About - '.config('twinbot.site.domain'))
@section('meta_description', 'TwinBot Innovations: embedded control systems and industrial automation products built for reliability and value.')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10 pb-16">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">About</h1>
            <p class="mt-4 max-w-4xl text-sm text-[#364151]">
                A team dedicated to transforming industrial automation with innovative, cost-effective solutions.
                We focus on high-quality, microcontroller-based technologies that enhance efficiency and product quality.
            </p>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-4">
            @foreach ([
                ['k' => '20%', 'v' => 'Fixed cost is lower than current PLC market rate.'],
                ['k' => '0%', 'v' => 'No compromise on reliability with custom embedded motherboards.'],
                ['k' => '1', 'v' => 'Year free maintenance visit.'],
                ['k' => '5', 'v' => 'ECS-based industrial projects successfully in production.'],
            ] as $s)
                <div class="rounded-3xl border border-black/10 bg-white p-6">
                    <div class="font-display text-3xl text-[#0067FF]">{{ $s['k'] }}</div>
                    <div class="mt-2 text-sm text-[#364151]">{{ $s['v'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2 md:items-start">
            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
                <h2 class="font-display text-2xl text-[#0F172A]">Our Mission</h2>
                <p class="mt-3 text-sm text-[#364151]">
                    To replace high-cost PLC systems with advanced embedded control systems (ECS) that are cost-effective and reliable.
                    We aim to empower manufacturers with solutions that enhance productivity and optimize operational costs.
                </p>
            </div>

            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
                <h2 class="font-display text-2xl text-[#0F172A]">Our Values</h2>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach ([
                        ['t' => 'Integrity', 'd' => 'Transparency and honesty in how we build and support.'],
                        ['t' => 'Safety', 'd' => 'Secure designs that are safe for people and environments.'],
                        ['t' => 'Customer Support', 'd' => 'Responsive support and maintenance after delivery.'],
                        ['t' => 'Innovation', 'd' => 'Practical innovation that improves real operations.'],
                    ] as $v)
                        <div class="rounded-2xl border border-black/10 bg-[#E7F6FF] p-4">
                            <div class="font-semibold text-[#0F172A]">{{ $v['t'] }}</div>
                            <div class="mt-1 text-xs text-[#364151]">{{ $v['d'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2 md:items-center">
            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
                <h2 class="font-display text-2xl text-[#0F172A]">Our Team</h2>
                <p class="mt-3 text-sm text-[#364151]">
                    Our journey is fueled by a shared passion for innovation and excellence.
                    Together, we are committed to creating impactful solutions in industrial automation and beyond.
                </p>

                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                    @foreach ([
                        ['name' => 'Murugesh', 'role' => 'Founder & CEO'],
                        ['name' => 'Lingappan', 'role' => 'Co-Founder'],
                        ['name' => 'Karthikeyan', 'role' => 'Seed Investor'],
                    ] as $m)
                        <div class="rounded-2xl border border-black/10 bg-white p-4">
                            <div class="font-semibold text-[#0F172A]">{{ $m['name'] }}</div>
                            <div class="mt-1 text-xs text-[#364151]">{{ $m['role'] }}</div>
                        </div>
                    @endforeach
                </div>

                <blockquote class="mt-6 rounded-2xl border border-black/10 bg-[#E7F6FF] p-5 text-sm text-[#364151]">
                    <div class="font-semibold text-[#0F172A]">"At TwinBot Innovations, we believe that innovation is not just about technology; it's about daring to dream and crafting tomorrow's solutions today. Every idea has the power to spark change."</div>
                    <div class="mt-2 text-xs font-semibold text-[#364151]">Murugesh</div>
                </blockquote>
            </div>

            <div class="overflow-hidden rounded-3xl border border-black/10 bg-white">
                <img src="{{ asset(config('twinbot.assets.about_team_image')) }}" alt="" class="h-full w-full object-cover" />
            </div>
        </div>
    </section>
@endsection

