@extends('layouts.site')

@section('title', 'Solutions | TwinBot Innovations')
@section('meta_description', 'TwinBot delivers custom embedded automation solutions for industrial quality control, machine integration, and process intelligence.')

@section('content')
    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Solution Architecture</span>
                <h1 class="tb-heading mt-4">Custom systems, engineered around your production reality.</h1>
                <p class="tb-lead mt-5 max-w-3xl">We do not publish client-sensitive solution blueprints publicly. Instead, we run a guided solution discovery process and share relevant technical references based on your domain, constraints, and scale.</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Start Confidential Discussion</a>
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">Review Product Blocks</a>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['title' => 'Inspection Automation', 'desc' => 'Dimensional measurement, tolerance logic, and pass/fail traceability built for throughput and consistency.'],
                    ['title' => 'Machine-Level Control', 'desc' => 'Embedded controllers for station automation, signal coordination, and deterministic behavior in harsh environments.'],
                    ['title' => 'Data and Reporting Layer', 'desc' => 'Capture process signals, structure event history, and build actionable dashboards for operations teams.'],
                    ['title' => 'Custom Electronics', 'desc' => 'Application-specific boards and interfacing modules tailored to your electrical and mechanical envelope.'],
                    ['title' => 'Retrofit Modernization', 'desc' => 'Upgrade legacy automation stacks with modern ECS architecture while preserving viable assets.'],
                    ['title' => 'Production Support', 'desc' => 'Deployment assistance, validation support, and iterative upgrades as your process matures.'],
                ] as $solution)
                    <article class="tb-card tb-reveal">
                        <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">Solution Track</div>
                        <h2 class="mt-2 font-display text-xl text-[#122E53]">{{ $solution['title'] }}</h2>
                        <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">{{ $solution['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-2">
                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Engagement Flow</span>
                    <h2 class="tb-subheading mt-3">How we define your solution</h2>
                    <div class="tb-process mt-5">
                        <div class="tb-step" data-step="01">
                            <h3>Requirement workshop</h3>
                            <p>We capture process pain points, measurement needs, cycle time goals, and environmental constraints.</p>
                        </div>
                        <div class="tb-step" data-step="02">
                            <h3>Architecture proposal</h3>
                            <p>You receive a practical control architecture with interfaces, data flow, and deployment assumptions.</p>
                        </div>
                        <div class="tb-step" data-step="03">
                            <h3>Pilot validation</h3>
                            <p>We verify performance on your real process so decisions are based on evidence, not assumptions.</p>
                        </div>
                        <div class="tb-step" data-step="04">
                            <h3>Scale-up roadmap</h3>
                            <p>We prepare phased rollout, support scope, and upgrade path for long-term reliability.</p>
                        </div>
                    </div>
                </div>

                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Confidentiality</span>
                    <h2 class="tb-subheading mt-3">Professional sharing model</h2>
                    <p class="tb-lead mt-3">Approved sample projects and detailed technical references are shared directly with verified business contacts after context alignment.</p>
                    <ul class="tb-list mt-4 text-sm">
                        <li>Client-specific details remain private and protected.</li>
                        <li>Reference material is shared only when relevant to your use case.</li>
                        <li>Engineering conversations stay focused on your goals, not generic templates.</li>
                    </ul>

                    <div class="mt-6 rounded-2xl border border-[#C7DDF0] bg-[#F2F9FF] p-5">
                        <div class="text-sm font-semibold text-[#285179]">Need examples before kickoff?</div>
                        <p class="mt-2 text-sm text-[#4F6890]">Reach out with your application context and we will share the closest comparable references in a professional discussion.</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary mt-4">Request Relevant References</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-cta tb-reveal">
                <span class="tb-eyebrow">Execution Partner</span>
                <h2 class="tb-subheading mt-3">Bring your toughest automation problem.</h2>
                <p class="tb-lead mt-3 max-w-2xl">We combine embedded engineering, measurement expertise, and field reality to deliver systems that perform in production, not just in presentation decks.</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Book a Technical Call</a>
                    <a href="{{ route('projects.index') }}" class="btn btn-ghost">See Published Projects</a>
                </div>
            </div>
        </div>
    </section>
@endsection

