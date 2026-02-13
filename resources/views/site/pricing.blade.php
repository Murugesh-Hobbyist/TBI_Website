@extends('layouts.site')

@section('title', 'Pricing | TwinBot Innovations')
@section('meta_description', 'TwinBot pricing model is designed around measurable value, lower ownership cost, and scalable embedded automation deployment.')

@section('content')
    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Commercial Clarity</span>
                <h1 class="tb-heading mt-4">Transparent value, engineered for industrial ROI.</h1>
                <p class="tb-lead mt-5 max-w-3xl">We price systems based on your technical scope, deployment scale, and support needs. The objective is simple: stronger control and measurement capability with lower lifetime cost than rigid legacy stacks.</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Request Pricing Consultation</a>
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">Explore Product Families</a>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['title' => 'Pilot Package', 'desc' => 'Fast validation package for teams testing feasibility, data flow, and process fit before full rollout.'],
                    ['title' => 'Production Package', 'desc' => 'Complete deployment with hardware, software, commissioning support, and operational handover.'],
                    ['title' => 'Scale Package', 'desc' => 'Expansion model for multi-line and multi-station deployments with staged rollout economics.'],
                ] as $plan)
                    <article class="tb-card tb-reveal">
                        <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">Model</div>
                        <h2 class="mt-2 font-display text-xl text-[#122E53]">{{ $plan['title'] }}</h2>
                        <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">{{ $plan['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-2">
                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Value Drivers</span>
                    <h2 class="tb-subheading mt-3">Why teams move budget toward ECS</h2>
                    <ul class="tb-list mt-5 text-sm">
                        <li>Lower ownership cost through focused architecture and practical spare strategy.</li>
                        <li>Reduced engineering friction with customizable firmware and interface flow.</li>
                        <li>Better operational insight through integrated data logging and diagnostics.</li>
                        <li>Faster scalability without complex module dependency chains.</li>
                    </ul>
                </div>

                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Included Benefits</span>
                    <h2 class="tb-subheading mt-3">Professional delivery standards</h2>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            'Technical consultation and scoping',
                            'Hardware and firmware alignment',
                            'Deployment and stabilization support',
                            'Post-go-live assistance options',
                            'Enclosure and protection planning',
                            'Documentation for operations team',
                        ] as $item)
                            <div class="tb-panel-soft p-4 text-sm font-semibold text-[#2D537A]">{{ $item }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-cta tb-reveal">
                <span class="tb-eyebrow">Estimate</span>
                <h2 class="tb-subheading mt-3">Share your requirement, get a realistic commercial path.</h2>
                <p class="tb-lead mt-3 max-w-2xl">Provide channels, sensing needs, timeline, and line constraints. We will respond with a proposal structure tailored to your project stage.</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Get Your Quote</a>
                    <a href="{{ route('solutions') }}" class="btn btn-ghost">Review Solution Approach</a>
                </div>
            </div>
        </div>
    </section>
@endsection

