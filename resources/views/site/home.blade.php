@extends('layouts.site')

@section('title', 'TwinBot Innovations | Embedded Automation Atlas')
@section('meta_description', 'TwinBot Innovations builds compact, scalable embedded automation systems for industrial control, traceability, and reliable production outcomes.')

@section('content')
    @php
        $compareRows = collect(config('twinbot.home.plc_vs_ecs', []));
        $heroStats = [
            ['value' => '20%+', 'label' => 'Typical ownership cost reduction'],
            ['value' => '5+', 'label' => 'Industrial deployments in production'],
            ['value' => '24/7', 'label' => 'Engineering support availability'],
            ['value' => '1 Year', 'label' => 'Free maintenance visit'],
        ];
    @endphp

    <section class="tb-section pt-4 md:pt-6">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-hero-shell p-5 md:p-7 tb-reveal">
                <div class="tb-hero-grid">
                    <div>
                        <span class="tb-eyebrow">Atlas Architecture</span>
                        <h1 class="tb-heading mt-3">
                            A cleaner automation stack for
                            <span class="tb-gradient-text">real production pressure.</span>
                        </h1>
                        <p class="tb-lead mt-3 max-w-2xl">
                            TwinBot replaces rigid PLC complexity with compact ECS platforms that improve operator flow,
                            simplify diagnostics, and scale faster from pilot to line rollout.
                        </p>

                        <div class="mt-4 flex flex-wrap gap-2.5">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Explore Products</a>
                            <a href="{{ route('contact') }}" class="btn btn-ghost">Talk to Engineering</a>
                        </div>

                        <div class="tb-hero-pills mt-4">
                            <span class="tb-hero-pill">Embedded Control</span>
                            <span class="tb-hero-pill">Inspection Automation</span>
                            <span class="tb-hero-pill">Industrial Data Logging</span>
                            <span class="tb-hero-pill">Custom Electronics</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="tb-signal-board">
                            <div class="tb-signal-title">What You Get</div>
                            <ul class="tb-list mt-2">
                                <li>Application-specific hardware and firmware aligned to your process.</li>
                                <li>Operator-first interfaces for faster pass/fail decisions.</li>
                                <li>Structured traceability ready for quality and reporting teams.</li>
                            </ul>
                        </div>

                        <div class="grid grid-cols-2 gap-2.5">
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
            <div class="tb-panel p-5 md:p-6">
                <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                    <div>
                        <span class="tb-eyebrow">Core Modules</span>
                        <h2 class="tb-subheading mt-2">Three layers that make the platform practical</h2>
                    </div>
                    <a href="{{ route('solutions') }}" class="btn btn-ghost">See Solution Tracks</a>
                </div>

                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    @foreach ([
                        ['title' => 'Control Core', 'copy' => 'Deterministic embedded control logic tailored for station-level reliability.'],
                        ['title' => 'Operator Layer', 'copy' => 'Simple UI flow with clear state visibility and low training overhead.'],
                        ['title' => 'Data Layer', 'copy' => 'Structured logging for auditability, fault triage, and continuous improvement.'],
                    ] as $module)
                        <article class="tb-card tb-reveal">
                            <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#627b97]">Module</div>
                            <h3 class="mt-2 font-display text-xl text-[#163353]">{{ $module['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-[#506a88]">{{ $module['copy'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-3 md:grid-cols-2">
                <div class="tb-panel p-5 md:p-6 tb-reveal">
                    <div class="flex items-center justify-between gap-3">
                        <span class="tb-eyebrow">Decision View</span>
                        <a href="{{ route('contact') }}" class="text-xs font-bold text-[#1f5e97]">Get advice</a>
                    </div>
                    <h2 class="tb-subheading mt-2">PLC pain vs ECS advantage</h2>

                    <div class="mt-3 grid gap-3">
                        @foreach ($compareRows as $row)
                            <details class="tb-compare" @if($loop->index < 2) open @endif>
                                <summary>{{ $row['aspect'] }}</summary>
                                <div class="tb-compare-body">
                                    <div class="tb-compare-item">
                                        <div class="tb-compare-label">Legacy Pattern</div>
                                        <p class="tb-compare-copy">{{ $row['plc'] }}</p>
                                    </div>
                                    <div class="tb-compare-item">
                                        <div class="tb-compare-label">TwinBot Approach</div>
                                        <p class="tb-compare-copy">{{ $row['ecs'] }}</p>
                                    </div>
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>

                <div class="tb-panel p-5 md:p-6 tb-reveal">
                    <span class="tb-eyebrow">Delivery Loop</span>
                    <h2 class="tb-subheading mt-2">From requirement to stable production</h2>

                    <div class="tb-process mt-3">
                        <div class="tb-step" data-step="01">
                            <h3>Scope and risk mapping</h3>
                            <p>Capture throughput, quality, and integration constraints before architecture lock.</p>
                        </div>
                        <div class="tb-step" data-step="02">
                            <h3>Hardware and firmware build</h3>
                            <p>Develop embedded control and UI in parallel for faster line readiness.</p>
                        </div>
                        <div class="tb-step" data-step="03">
                            <h3>Validation on real process signals</h3>
                            <p>Verify pass/fail logic, data integrity, and operator workflow under real load.</p>
                        </div>
                        <div class="tb-step" data-step="04">
                            <h3>Rollout and support</h3>
                            <p>Commission with lifecycle support and iterative performance improvements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-3 md:grid-cols-[1.1fr_0.9fr]">
                <div class="tb-panel p-5 md:p-6 tb-reveal">
                    <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                        <div>
                            <span class="tb-eyebrow">Product Focus</span>
                            <h2 class="tb-subheading mt-2">Built for measurable shop-floor outcomes</h2>
                        </div>
                        <a href="{{ route('products.index') }}" class="btn btn-ghost">Full Catalog</a>
                    </div>

                    <div class="mt-4 grid gap-3 md:grid-cols-3">
                        @forelse (($featuredProducts ?? collect())->take(3) as $p)
                            @php
                                $img = $p['image'] ?? null;
                                $src = $img && \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : ($img ? asset($img) : null);
                            @endphp
                            <a href="{{ route('products.show', ['product' => $p['slug']]) }}" class="tb-card group">
                                @if ($src)
                                    <div class="tb-product-thumb">
                                        <img src="{{ $src }}" alt="{{ $p['title'] }}" class="h-full w-full object-contain transition duration-200 group-hover:scale-[1.03]" />
                                    </div>
                                @endif
                                <div class="mt-3 text-xs font-extrabold uppercase tracking-[0.12em] text-[#5f7a98]">{{ $p['series'] ?? 'Product' }}</div>
                                <div class="mt-1 font-display text-lg text-[#173553]">{{ $p['title'] }}</div>
                            </a>
                        @empty
                            <div class="tb-panel-soft p-4 text-sm text-[#4f6888] md:col-span-3">Featured products will appear here once published.</div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="tb-panel p-5 md:p-6 tb-reveal">
                        <span class="tb-eyebrow">Trusted Teams</span>
                        <h2 class="tb-subheading mt-2">Brands that built with TwinBot</h2>
                        <div class="tb-logo-grid mt-4">
                            @foreach (config('twinbot.assets.trusted_logos', []) as $logo)
                                <div class="tb-logo-card">
                                    <img src="{{ asset($logo) }}" alt="Trusted brand" class="max-h-9 w-auto object-contain" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tb-cta tb-reveal">
                        <span class="tb-eyebrow">Next Step</span>
                        <h2 class="tb-subheading mt-2">Need a custom architecture plan?</h2>
                        <p class="tb-lead mt-2">Share your process context and we will propose a practical rollout path.</p>
                        <div class="mt-4 flex flex-wrap gap-2.5">
                            <a href="{{ route('contact') }}" class="btn btn-primary">Request Proposal</a>
                            <a href="{{ route('projects.index') }}" class="btn btn-ghost">View Projects</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
