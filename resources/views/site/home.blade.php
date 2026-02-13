@extends('layouts.site')

@section('title', 'TwinBot Innovations | Embedded Automation Reimagined')
@section('meta_description', 'TwinBot Innovations designs embedded control systems, precision measurement platforms, and industrial automation products that are clear, scalable, and production-ready.')

@section('content')
    @php
        $compareRows = collect(config('twinbot.home.plc_vs_ecs', []));
        $heroStats = [
            ['value' => '20%+', 'label' => 'Lower platform ownership cost'],
            ['value' => '5+', 'label' => 'Industrial lines running live'],
            ['value' => '24/7', 'label' => 'Engineering response coverage'],
            ['value' => '1 Year', 'label' => 'Free maintenance visit'],
        ];

        $signalBlocks = [
            ['value' => '92.8%', 'label' => 'First-pass inspection confidence'],
            ['value' => '3.2x', 'label' => 'Faster line fault traceability'],
            ['value' => '<45m', 'label' => 'Average pilot setup cycle'],
            ['value' => '99.2%', 'label' => 'Runtime stability observed'],
        ];

        $valuePillars = [
            [
                'title' => 'Operator-Clear Interfaces',
                'copy' => 'Fewer clicks, clearer pass/fail states, and predictable flow for shift-level execution.',
            ],
            [
                'title' => 'Modular Embedded Core',
                'copy' => 'Purpose-built electronics and firmware blocks that scale from pilot station to production line.',
            ],
            [
                'title' => 'Actionable Visibility Layer',
                'copy' => 'Traceable event logging and structured diagnostics so decisions come from evidence.',
            ],
        ];
    @endphp

    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-hero-shell p-6 md:p-10 tb-reveal">
                <div class="tb-hero-grid">
                    <div>
                        <span class="tb-eyebrow">Automation Studio 2.0</span>
                        <h1 class="tb-heading mt-5">
                            Industrial systems, redesigned for
                            <span class="tb-gradient-text">speed, clarity, and scale.</span>
                        </h1>
                        <p class="tb-lead mt-5 max-w-2xl">
                            TwinBot builds embedded control and inspection platforms that eliminate unnecessary PLC complexity,
                            simplify operator workflows, and keep production teams confident from pilot to full rollout.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Explore Product Systems</a>
                            <a href="{{ route('contact') }}" class="btn btn-ghost">Start Technical Consultation</a>
                        </div>

                        <div class="tb-hero-pills mt-7">
                            <span class="tb-hero-pill">Embedded Control Systems</span>
                            <span class="tb-hero-pill">Inspection Automation</span>
                            <span class="tb-hero-pill">Industrial Data Logging</span>
                            <span class="tb-hero-pill">Custom Electronics</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="tb-signal-board">
                            <div class="tb-signal-title">Live Execution Signals</div>
                            <p class="tb-signal-copy">Representative outcomes from deployment-first architecture across production environments.</p>
                            <div class="tb-signal-grid">
                                @foreach ($signalBlocks as $block)
                                    <div class="tb-signal-item">
                                        <div class="tb-signal-value">{{ $block['value'] }}</div>
                                        <div class="tb-signal-label">{{ $block['label'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            @foreach ($heroStats as $stat)
                                <div class="tb-stat">
                                    <div class="tb-stat-value">{{ $stat['value'] }}</div>
                                    <div class="tb-stat-label">{{ $stat['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-8">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div>
                        <span class="tb-eyebrow">Why Teams Switch</span>
                        <h2 class="tb-subheading mt-3">What makes TwinBot platforms feel different on the floor</h2>
                    </div>
                    <a href="{{ route('solutions') }}" class="btn btn-ghost">See Solution Tracks</a>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    @foreach ($valuePillars as $pillar)
                        <article class="tb-card tb-reveal">
                            <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#5f7a98]">Advantage</div>
                            <h3 class="mt-2 font-display text-xl text-[#122f54]">{{ $pillar['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-[#4d688f]">{{ $pillar['copy'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <span class="tb-eyebrow">Decision Clarity</span>
                        <h2 class="tb-subheading mt-3">Legacy PLC pain vs ECS execution advantage</h2>
                        <p class="tb-lead mt-2 max-w-3xl">Use these quick comparison modules to align management and engineering teams around practical architecture choices.</p>
                    </div>
                    <a href="{{ route('contact') }}" class="btn btn-ghost">Get Architecture Advice</a>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    @foreach ($compareRows as $row)
                        <details class="tb-compare tb-reveal" @if($loop->index < 2) open @endif>
                            <summary>{{ $row['aspect'] }}</summary>
                            <div class="tb-compare-body">
                                <div class="tb-compare-item">
                                    <div class="tb-compare-label">Legacy PLC Pattern</div>
                                    <p class="tb-compare-copy">{{ $row['plc'] }}</p>
                                </div>
                                <div class="tb-compare-item">
                                    <div class="tb-compare-label">TwinBot ECS Approach</div>
                                    <p class="tb-compare-copy">{{ $row['ecs'] }}</p>
                                </div>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-2">
                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Execution Flow</span>
                    <h2 class="tb-subheading mt-3">From requirements to stable production integration</h2>

                    <div class="tb-process mt-5">
                        <div class="tb-step" data-step="01">
                            <h3>Process discovery and risk mapping</h3>
                            <p>We map your quality targets, machine constraints, and operator friction before locking architecture.</p>
                        </div>
                        <div class="tb-step" data-step="02">
                            <h3>Embedded system design sprint</h3>
                            <p>Hardware, firmware, and interface are tuned together to match your exact line behavior.</p>
                        </div>
                        <div class="tb-step" data-step="03">
                            <h3>Validation on real production signals</h3>
                            <p>Pass/fail logic, logging integrity, and throughput behavior are verified before deployment sign-off.</p>
                        </div>
                        <div class="tb-step" data-step="04">
                            <h3>Rollout with lifecycle support</h3>
                            <p>We support commissioning, stabilization, and iterative upgrades without disrupting operations.</p>
                        </div>
                    </div>
                </div>

                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Sail OS Layer</span>
                    <h2 class="tb-subheading mt-3">Control intelligence that teams can actually use</h2>
                    <p class="tb-lead mt-3">Sail OS transforms raw machine data into action-ready operator and supervisor views with clean traceability.</p>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            'Real-time production dashboards',
                            'Structured fault/event history',
                            'Pass/fail traceability models',
                            'Flexible sensor-device interfacing',
                            'Operator-focused UX flows',
                            'Ready for IoT + analytics stack',
                        ] as $item)
                            <div class="tb-panel-soft p-4 text-sm font-semibold text-[#2d557e]">{{ $item }}</div>
                        @endforeach
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('features') }}" class="btn btn-primary">View Platform Features</a>
                        <a href="{{ route('solutions') }}" class="btn btn-ghost">See Solution Tracks</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-8">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div>
                        <span class="tb-eyebrow">Product Portfolio</span>
                        <h2 class="tb-subheading mt-3">Precision devices built for real production outcomes</h2>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">Browse Full Catalog</a>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    @foreach (($featuredProducts ?? collect()) as $p)
                        @php
                            $img = $p['image'] ?? null;
                            $src = $img && \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : ($img ? asset($img) : null);
                        @endphp
                        <a href="{{ route('products.show', ['product' => $p['slug']]) }}" class="tb-card tb-reveal group">
                            @if ($src)
                                <div class="tb-product-thumb">
                                    <img src="{{ $src }}" alt="{{ $p['title'] }}" class="h-full w-full object-contain transition duration-200 group-hover:scale-[1.03]" />
                                </div>
                            @endif
                            <div class="mt-4 text-xs font-extrabold uppercase tracking-[0.14em] text-[#607b9a]">{{ $p['series'] ?? 'Product' }}</div>
                            <div class="mt-2 font-display text-xl text-[#132b4d]">{{ $p['title'] }}</div>
                            @if (!empty($p['summary']))
                                <p class="mt-2 text-sm leading-relaxed text-[#4f6890]">{{ \Illuminate\Support\Str::limit(strip_tags((string) $p['summary']), 130) }}</p>
                            @endif
                            <div class="mt-4 text-sm font-bold text-[#1f6fd0]">Explore details</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-[1fr_0.95fr]">
                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Trusted Collaborations</span>
                    <h2 class="tb-subheading mt-3">Teams that built with TwinBot</h2>
                    <div class="tb-logo-grid mt-6">
                        @foreach (config('twinbot.assets.trusted_logos', []) as $logo)
                            <div class="tb-logo-card">
                                <img src="{{ asset($logo) }}" alt="Trusted brand" class="max-h-10 w-auto object-contain" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="tb-cta tb-reveal">
                    <span class="tb-eyebrow">Next Step</span>
                    <h2 class="tb-subheading mt-3">Need a control system tailored to your line?</h2>
                    <p class="tb-lead mt-3">Share your production context. We will propose the right control architecture, measurement strategy, and rollout model.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('contact') }}" class="btn btn-primary">Request Proposal</a>
                        <a href="{{ route('projects.index') }}" class="btn btn-ghost">View Project Stories</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
