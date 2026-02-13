@extends('layouts.site')

@section('title', 'About | TwinBot Innovations')
@section('meta_description', 'Meet TwinBot Innovations: an embedded automation team focused on reliable industrial systems, measurable value, and long-term customer support.')

@section('content')
    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Who We Are</span>
                <h1 class="tb-heading mt-4">Engineers building practical automation that works in production.</h1>
                <p class="tb-lead mt-5 max-w-3xl">TwinBot Innovations was founded to close the gap between expensive, rigid industrial control stacks and the real needs of modern manufacturing teams. We design embedded platforms that are clear, dependable, and economically sensible.</p>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-4 md:grid-cols-4">
                @foreach ([
                    ['k' => '20%+', 'v' => 'Typical reduction in fixed platform cost versus traditional options'],
                    ['k' => '0%', 'v' => 'Compromise on reliability when systems are engineered correctly'],
                    ['k' => '1 Year', 'v' => 'Free maintenance visit included after deployment'],
                    ['k' => '5+', 'v' => 'ECS-based industrial projects running in production'],
                ] as $metric)
                    <article class="tb-card tb-reveal">
                        <div class="font-display text-3xl text-[#1F6FD0]">{{ $metric['k'] }}</div>
                        <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">{{ $metric['v'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-2">
                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Mission</span>
                    <h2 class="tb-subheading mt-3">Replace unnecessary complexity with focused embedded intelligence.</h2>
                    <p class="tb-lead mt-4">Our mission is to help manufacturers improve quality, reduce operating friction, and scale with confidence by deploying purpose-built ECS platforms in place of overengineered control setups.</p>
                </div>

                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Values</span>
                    <h2 class="tb-subheading mt-3">How we work with clients</h2>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['title' => 'Integrity', 'desc' => 'Clear communication, realistic timelines, and honest tradeoff discussion.'],
                            ['title' => 'Safety', 'desc' => 'Reliable control design with practical safeguards for operators and assets.'],
                            ['title' => 'Support', 'desc' => 'We stay involved after delivery to stabilize and improve real outcomes.'],
                            ['title' => 'Innovation', 'desc' => 'We prioritize useful innovation that solves operational pain, not hype.'],
                        ] as $value)
                            <div class="tb-panel-soft p-4">
                                <div class="font-semibold text-[#1B4A74]">{{ $value['title'] }}</div>
                                <p class="mt-1 text-sm text-[#4F6890]">{{ $value['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-[1.1fr_0.9fr] md:items-stretch">
                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Leadership Team</span>
                    <h2 class="tb-subheading mt-3">People behind TwinBot</h2>
                    <div class="mt-5 grid gap-3 sm:grid-cols-3">
                        @foreach ([
                            ['name' => 'Murugesh', 'role' => 'Founder & CEO'],
                            ['name' => 'Lingappan', 'role' => 'Co-Founder'],
                            ['name' => 'Karthikeyan', 'role' => 'Seed Investor'],
                        ] as $member)
                            <div class="tb-panel-soft p-4">
                                <div class="font-semibold text-[#1B4A74]">{{ $member['name'] }}</div>
                                <div class="mt-1 text-xs font-semibold uppercase tracking-[0.1em] text-[#64809D]">{{ $member['role'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <blockquote class="mt-6 rounded-2xl border border-[#C6DCEF] bg-[#F2F9FF] p-5 text-sm leading-relaxed text-[#4A678A]">
                        <div class="font-semibold text-[#1B4A74]">"Innovation is valuable only when it solves a real production problem with clarity and reliability."</div>
                        <div class="mt-2 text-xs font-bold uppercase tracking-[0.08em] text-[#607E9C]">Murugesh, Founder</div>
                    </blockquote>
                </div>

                <div class="tb-panel overflow-hidden tb-reveal">
                    <img src="{{ asset(config('twinbot.assets.about_team_image')) }}" alt="TwinBot team" class="h-full w-full object-cover" />
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-cta tb-reveal">
                <span class="tb-eyebrow">Collaborate</span>
                <h2 class="tb-subheading mt-3">Need a serious automation partner?</h2>
                <p class="tb-lead mt-3 max-w-2xl">If your team needs an embedded platform that can survive production pressure, we are ready to design it with you.</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Connect With TwinBot</a>
                    <a href="{{ route('projects.index') }}" class="btn btn-ghost">See Execution Proof</a>
                </div>
            </div>
        </div>
    </section>
@endsection

