@extends('layouts.site')

@section('title', 'TwinBot Innovations | Embedded Automation Reimagined')
@section('meta_description', 'TwinBot Innovations designs embedded control systems, precision measurement platforms, and industrial automation products that are clear, scalable, and production-ready.')

@section('content')
    @php
        $compareRows = collect(config('twinbot.home.plc_vs_ecs', []));
        $heroStats = [
            ['value' => '20%+', 'label' => 'Lower typical platform cost'],
            ['value' => '5+', 'label' => 'Industrial projects in production'],
            ['value' => '24/7', 'label' => 'Engineering support coverage'],
            ['value' => '1 Year', 'label' => 'Free maintenance visit'],
        ];
    @endphp

    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel overflow-hidden p-6 md:p-10 tb-reveal">
                <div class="grid gap-10 md:grid-cols-[1.2fr_0.8fr] md:items-start">
                    <div>
                        <span class="tb-eyebrow">Industrial Automation, Reframed</span>
                        <h1 class="tb-heading mt-5">
                            Better than legacy PLC stacks.
                            <span class="block text-[#0B6ECD]">Purpose-built ECS platforms for faster, cleaner execution.</span>
                        </h1>
                        <p class="tb-lead mt-5 max-w-2xl">
                            TwinBot builds embedded control systems that remove unnecessary hardware complexity, make operator workflows clearer,
                            and give engineering teams higher confidence from pilot to production.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Explore Products</a>
                            <a href="{{ route('contact') }}" class="btn btn-ghost">Start a Project Discussion</a>
                        </div>

                        <div class="mt-7 flex flex-wrap gap-2">
                            <span class="tb-tag">Embedded Control Systems</span>
                            <span class="tb-tag">Inspection Automation</span>
                            <span class="tb-tag">Industrial Data Logging</span>
                            <span class="tb-tag">Custom Electronics</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="tb-panel-soft p-5">
                            <div class="text-sm font-extrabold tracking-wide text-[#184D85]">What You Get</div>
                            <ul class="tb-list mt-2 text-sm">
                                <li>Application-specific hardware and firmware designed around your production reality.</li>
                                <li>Operator-friendly interfaces focused on speed, traceability, and reduced manual error.</li>
                                <li>Scalable architecture ready for IoT integration, reporting, and future process upgrades.</li>
                            </ul>
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
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <span class="tb-eyebrow">Decision Clarity</span>
                        <h2 class="tb-subheading mt-3">PLC Pain vs ECS Advantage</h2>
                        <p class="tb-lead mt-2 max-w-3xl">We converted the old comparison table into quick decision cards so teams can scan faster and align sooner.</p>
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
                    <span class="tb-eyebrow">How We Execute</span>
                    <h2 class="tb-subheading mt-3">From requirement to reliable deployment</h2>

                    <div class="tb-process mt-5">
                        <div class="tb-step" data-step="01">
                            <h3>Discovery and scope framing</h3>
                            <p>We map your process, quality risks, and throughput targets before selecting architecture.</p>
                        </div>
                        <div class="tb-step" data-step="02">
                            <h3>System design and prototype</h3>
                            <p>Hardware, firmware, and interface are tuned to your exact line constraints and operator flow.</p>
                        </div>
                        <div class="tb-step" data-step="03">
                            <h3>Validation and line integration</h3>
                            <p>We verify pass/fail logic, data capture, and performance before controlled production rollout.</p>
                        </div>
                        <div class="tb-step" data-step="04">
                            <h3>Support and iterative upgrades</h3>
                            <p>Post-deployment support keeps your platform stable while enabling growth-focused enhancements.</p>
                        </div>
                    </div>
                </div>

                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Platform Layer</span>
                    <h2 class="tb-subheading mt-3">Sail OS for industrial visibility</h2>
                    <p class="tb-lead mt-3">Our Sail OS layer translates raw machine signals into actionable, human-readable insights for operators and supervisors.</p>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            'Real-time production dashboards',
                            'Structured event and fault logging',
                            'Clear pass/fail traceability',
                            'Flexible sensor/device interfacing',
                            'Low-friction operator UX',
                            'Ready for IoT and analytics',
                        ] as $item)
                            <div class="tb-panel-soft p-4 text-sm font-semibold text-[#274B73]">{{ $item }}</div>
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
                        <h2 class="tb-subheading mt-3">Precision devices built for real shop-floor outcomes</h2>
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
                            <div class="mt-4 text-xs font-extrabold uppercase tracking-[0.14em] text-[#5B7698]">{{ $p['series'] ?? 'Product' }}</div>
                            <div class="mt-2 font-display text-xl text-[#0F1F38]">{{ $p['title'] }}</div>
                            @if (!empty($p['summary']))
                                <p class="mt-2 text-sm leading-relaxed text-[#4C6686]">{{ \Illuminate\Support\Str::limit(strip_tags((string) $p['summary']), 130) }}</p>
                            @endif
                            <div class="mt-4 text-sm font-bold text-[#0B6ECD]">Explore details</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-[1fr_0.9fr]">
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
                    <h2 class="tb-subheading mt-3">Want a system tailored to your line?</h2>
                    <p class="tb-lead mt-3">Share your requirement. We will suggest the right control architecture, measurement strategy, and rollout plan.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('contact') }}" class="btn btn-primary">Request Proposal</a>
                        <a href="{{ route('projects.index') }}" class="btn btn-ghost">View Project Stories</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
