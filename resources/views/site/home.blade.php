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
        .tb-pitch { overflow: hidden; background: radial-gradient(circle at 85% 14%, rgba(27, 198, 169, .18), transparent 27%), linear-gradient(135deg, #0b2544, #123f70); color: #fff; }
        .tb-pitch .tb-eyebrow { color: #9feadf; border-color: rgba(159,234,223,.35); background: rgba(255,255,255,.08); }
        .tb-pitch h2, .tb-pitch p { color: #fff; }
        .tb-pitch-orbit { position: absolute; right: -5rem; top: -6rem; width: 19rem; height: 19rem; border: 1px solid rgba(159,234,223,.25); border-radius: 50%; animation: tb-orbit 14s linear infinite; }
        .tb-pitch-orbit::before, .tb-pitch-orbit::after { content: ''; position: absolute; width: .7rem; height: .7rem; border-radius: 50%; background: #35dac1; box-shadow: 0 0 20px #35dac1; } .tb-pitch-orbit::before { top: 2rem; left: 2.4rem; } .tb-pitch-orbit::after { bottom: 2rem; right: 2.4rem; }
        .tb-pitch-grid { position: relative; display: grid; gap: 1rem; margin-top: 2rem; } .tb-pitch-card { position: relative; padding: 1.25rem; border: 1px solid rgba(255,255,255,.16); border-radius: 1rem; background: rgba(255,255,255,.08); backdrop-filter: blur(10px); opacity: 0; transform: translateY(20px); transition: .65s ease; transition-delay: var(--pitch-delay); }
        .tb-pitch.is-live .tb-pitch-card { opacity: 1; transform: translateY(0); }
        .tb-pitch-card::before { content: attr(data-index); display: inline-flex; width: 1.8rem; height: 1.8rem; align-items: center; justify-content: center; border-radius: 50%; background: #ff5d62; color: #fff; font-size: .72rem; font-weight: 800; }
        .tb-pitch-card h3 { margin-top: .75rem; color: #fff; font-family: 'Chakra Petch', sans-serif; font-size: 1.15rem; } .tb-pitch-card p { margin-top: .45rem; color: #c9dcf1; font-size: .86rem; line-height: 1.55; }
        .tb-pitch-card--ecs { border-color: rgba(53,218,193,.55); background: linear-gradient(145deg, rgba(53,218,193,.24), rgba(255,255,255,.08)); } .tb-pitch-card--ecs::before { background: #1fc7aa; }
        .tb-pitch-vs { display: grid; gap: .8rem; } .tb-pitch-vs strong { color: #ffbec0; font-size: .76rem; letter-spacing: .09em; text-transform: uppercase; } .tb-pitch-vs span { color: #a8f1e4; font-size: .76rem; letter-spacing: .09em; text-transform: uppercase; }
        .tb-pitch-tag { display: inline-flex; margin-top: 1.4rem; padding: .5rem .8rem; border-radius: 999px; background: rgba(255,255,255,.1); color: #d9ecff; font-size: .78rem; font-weight: 700; }
        .tb-section .tb-panel, .tb-section .tb-cta { transition: transform .35s ease, box-shadow .35s ease; } .tb-section .tb-panel:hover, .tb-section .tb-cta:hover { transform: translateY(-4px); box-shadow: 0 20px 42px rgba(29,88,147,.14); }
        @keyframes tb-orbit { to { transform: rotate(360deg); } }
        @media (min-width: 768px) { .tb-pitch-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } .tb-pitch-card:nth-child(3) { grid-column: 1 / -1; } }
        @media (max-width: 767px) { .tb-flow-node::before { display: none; } .tb-flow-line { height: 2.5rem; } }
    </style>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-pitch tb-panel relative p-6 md:p-10">
                <div class="tb-pitch-orbit" aria-hidden="true"></div>
                <div class="relative z-10 max-w-3xl">
                    <div>
                        <span class="tb-eyebrow">The TwinBot pitch</span>
                        <h2 class="tb-heading mt-4">Stop paying the <span class="text-[#35dac1]">PLC complexity tax.</span></h2>
                        <p class="mt-4 max-w-2xl text-base leading-relaxed text-[#d6e9ff]">The same production target can feel completely different on the floor. TwinBot ECS replaces cabinet archaeology with clear, evidence-led execution.</p>
                    </div>
                    <div class="tb-pitch-grid">
                        @foreach ($compareRows as $row)
                            <article class="tb-pitch-card" data-index="0{{ $loop->iteration }}" style="--pitch-delay: {{ $loop->index * 0.12 }}s">
                                <h3>{{ $row['aspect'] }}</h3>
                                <div class="tb-pitch-vs mt-4"><strong>Legacy PLC: {{ $row['plc'] }}</strong><span>TwinBot ECS: {{ $row['ecs'] }}</span></div>
                            </article>
                        @endforeach
                    </div>
                    <div class="tb-pitch-tag">Less cabinet archaeology. More production confidence.</div>
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

@push('scripts')
    <script>
        document.querySelectorAll('.tb-pitch').forEach(function (pitch) {
            if (!('IntersectionObserver' in window)) {
                pitch.classList.add('is-live');
                return;
            }

            new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        pitch.classList.add('is-live');
                        observer.unobserve(pitch);
                    }
                });
            }, { threshold: 0.22 }).observe(pitch);
        });
    </script>
@endpush
