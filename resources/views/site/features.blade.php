@extends('layouts.site')

@section('title', 'Features | TwinBot Innovations')
@section('meta_description', 'Explore TwinBot platform features: scalable embedded control, traceable quality workflows, secure integration, and production-ready operator interfaces.')

@section('content')
    <section class="tb-section pt-6 md:pt-10">
        <div class="tb-wrap">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Capabilities</span>
                <h1 class="tb-heading mt-4">Everything your automation stack needs, without the clutter.</h1>
                <p class="tb-lead mt-5 max-w-3xl">Each feature is engineered to improve deployment speed, operator confidence, and long-term maintainability for industrial teams.</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('solutions') }}" class="btn btn-primary">See Solution Models</a>
                    <a href="{{ route('contact') }}" class="btn btn-ghost">Discuss Your Use Case</a>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="tb-wrap">
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['title' => 'Native System Integration', 'desc' => 'Connect sensors, dials, HMIs, and enterprise workflows without fragile patchwork layers.'],
                    ['title' => 'Operator-First UX', 'desc' => 'Simple, responsive interface flow designed for real shift usage and faster decision-making.'],
                    ['title' => 'Cross-Platform Compatibility', 'desc' => 'Built to coexist with existing hardware and process ecosystems during phased migration.'],
                    ['title' => 'Scalable Architecture', 'desc' => 'Start with a focused station and expand to multi-line deployments as demand increases.'],
                    ['title' => 'Security by Design', 'desc' => 'Controlled access, reliable data handling, and safeguards for production-critical operations.'],
                    ['title' => 'Data Visibility', 'desc' => 'Structured logs, diagnostics, and traceability that help teams resolve issues faster.'],
                ] as $feature)
                    <article class="tb-card tb-reveal">
                        <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">Feature</div>
                        <h2 class="mt-2 font-display text-xl text-[#122E53]">{{ $feature['title'] }}</h2>
                        <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">{{ $feature['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="tb-wrap">
            <div class="grid gap-5 md:grid-cols-2">
                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Engineering Backbone</span>
                    <h2 class="tb-subheading mt-3">Built for industrial constraints, not demo conditions.</h2>
                    <ul class="tb-list mt-5 text-sm">
                        <li>Fast boot and stable runtime behavior for high-uptime requirements.</li>
                        <li>Clear diagnostics to simplify support and reduce troubleshooting time.</li>
                        <li>Modular firmware strategy for controlled updates and feature growth.</li>
                        <li>Flexible communication options for local devices and cloud pipelines.</li>
                    </ul>
                </div>

                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Operational Benefits</span>
                    <h2 class="tb-subheading mt-3">What teams notice after deployment</h2>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            'Faster line onboarding',
                            'Lower maintenance overhead',
                            'Improved measurement consistency',
                            'Reduced manual intervention',
                            'Actionable production reporting',
                            'Reliable after-sales support',
                        ] as $benefit)
                            <div class="tb-panel-soft p-4 text-sm font-semibold text-[#2D537A]">{{ $benefit }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="tb-wrap">
            <div class="tb-cta tb-reveal">
                <span class="tb-eyebrow">Ready To Build</span>
                <h2 class="tb-subheading mt-3">Tell us your process. We will map the right feature stack.</h2>
                <p class="tb-lead mt-3 max-w-2xl">From single-station automation to multi-stage inspection systems, we tailor the platform around your operational goals.</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Talk to Engineering</a>
                    <a href="{{ route('pricing') }}" class="btn btn-ghost">Understand Commercial Model</a>
                </div>
            </div>
        </div>
    </section>
@endsection


