@extends('layouts.site')

@section('title', 'TwinBot Innovations | Embedded Automation Reimagined')
@section('meta_description', 'TwinBot Innovations designs embedded control systems, precision measurement platforms, and industrial automation products that are clear, scalable, and production-ready.')

@section('content')
    @php
        $compareRows = collect(config('twinbot.home.plc_vs_ecs', []));
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
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <div class="mx-auto max-w-4xl text-center">
                    <span class="tb-eyebrow">TwinBot Platform Flow</span>
                    <h1 class="tb-heading mt-4">From control complexity to confident execution.</h1>
                    <p class="tb-lead mx-auto mt-5 max-w-3xl">TwinBot builds embedded control and inspection platforms that eliminate unnecessary PLC complexity, simplify operator workflows, and keep production teams confident from pilot to full rollout.</p>
                </div>

                <div class="tb-flowchart mt-9">
                    <div class="tb-flow-source">
                        <span class="tb-flow-pulse"></span>
                        <span>Production challenge</span>
                    </div>
                    <div class="tb-flow-line" aria-hidden="true"><span></span></div>
                    <div class="grid gap-4 md:grid-cols-3">
                        @foreach ($valuePillars as $pillar)
                            <article class="tb-flow-node" style="--flow-delay: {{ $loop->index * 0.35 }}s">
                                <div class="tb-flow-index">0{{ $loop->iteration }}</div>
                                <h2>{{ $pillar['title'] }}</h2>
                                <p>{{ $pillar['copy'] }}</p>
                            </article>
                        @endforeach
                    </div>
                    <div class="tb-flow-outcome"><span></span>Clearer actions. Stronger evidence. Confident rollout.</div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .tb-flowchart { position: relative; }
        .tb-flow-source, .tb-flow-outcome { display: flex; align-items: center; justify-content: center; gap: .7rem; margin: 0 auto; width: fit-content; border-radius: 999px; padding: .7rem 1.1rem; font-size: .76rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: #173e69; background: #e8f5ff; border: 1px solid #b9d9f4; }
        .tb-flow-pulse { width: .55rem; height: .55rem; border-radius: 50%; background: #19c4a8; box-shadow: 0 0 0 0 rgba(25, 196, 168, .6); animation: tb-flow-pulse 1.8s infinite; }
        .tb-flow-line { position: relative; height: 3.5rem; width: 2px; margin: 0 auto; overflow: hidden; background: #bdd7ee; }
        .tb-flow-line span { display: block; width: 100%; height: 35%; background: linear-gradient(#1f6fd0, #19c4a8); animation: tb-flow-signal 1.6s ease-in-out infinite; }
        .tb-flow-node { position: relative; min-height: 12.2rem; padding: 1.5rem; border: 1px solid #c7dff4; border-radius: 1.25rem; background: linear-gradient(145deg, #fff, #eef8ff); box-shadow: 0 14px 28px rgba(28, 91, 152, .1); animation: tb-flow-rise .7s both; animation-delay: var(--flow-delay); }
        .tb-flow-node::before { content: ''; position: absolute; top: -1.1rem; left: 50%; width: 1px; height: 1.1rem; background: #bdd7ee; }
        .tb-flow-index { display: inline-flex; align-items: center; justify-content: center; width: 2.3rem; height: 2.3rem; border-radius: .75rem; color: #fff; background: linear-gradient(135deg, #1f6fd0, #19c4a8); font-size: .78rem; font-weight: 800; }
        .tb-flow-node h2 { margin-top: 1rem; color: #122f54; font-family: 'Chakra Petch', sans-serif; font-size: 1.3rem; line-height: 1.15; }
        .tb-flow-node p { margin-top: .7rem; color: #4d688f; font-size: .9rem; line-height: 1.6; }
        .tb-flow-outcome { margin-top: 2rem; color: #0d5b57; background: #eafbf6; border-color: #a9e4d5; letter-spacing: .07em; }
        .tb-flow-outcome span { width: .55rem; height: .55rem; border-radius: 50%; background: #19c4a8; }
        @keyframes tb-flow-signal { from { transform: translateY(-120%); } to { transform: translateY(320%); } }
        @keyframes tb-flow-pulse { 70% { box-shadow: 0 0 0 .6rem rgba(25, 196, 168, 0); } 100% { box-shadow: 0 0 0 0 rgba(25, 196, 168, 0); } }
        @keyframes tb-flow-rise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 767px) { .tb-flow-node::before { display: none; } .tb-flow-line { height: 2.5rem; } }
    </style>

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
                                <img src="{{ asset($logo) }}" alt="Trusted brand" class="max-h-11 max-w-full w-auto object-contain" />
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
