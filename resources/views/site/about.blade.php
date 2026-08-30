@extends('layouts.site')

@section('title', 'About | TwinBot Innovations')
@section('meta_description', 'Meet TwinBot Innovations: an embedded automation team focused on reliable industrial systems, measurable value, and long-term customer support.')

@section('content')
    <section class="tb-section pt-6 md:pt-10">
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

    @php
        $leadershipTeam = [
            [
                'name' => 'Murugesh',
                'role' => 'Founder & CEO',
                'image' => 'twinbot/about/leadership/murugesh.jpg',
            ],
            [
                'name' => 'Lingappan',
                'role' => 'Hardware Engineer',
                'image' => 'twinbot/about/leadership/lingappan.png',
            ],
            [
                'name' => 'Karthikeyan',
                'role' => 'Seed Investor',
                'image' => 'twinbot/about/leadership/karthikeyan.png',
            ],
        ];
    @endphp

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-8 tb-reveal">
                <span class="tb-eyebrow">Leadership Team</span>
                <h2 class="tb-subheading mt-3">People behind TwinBot</h2>
                <p class="tb-lead mt-3 max-w-4xl">
                    Our journey is fueled by a shared passion for innovation and excellence. As the founder, Murugesh led the charge in shaping the vision and developing the products, with his brother Lingappan contributing in the early stages as a hardware engineer. Karthikeyan, the seed investor, helped enable the team to turn ideas into real industrial automation solutions.
                </p>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    @foreach ($leadershipTeam as $member)
                        <article class="tb-panel-soft overflow-hidden">
                            <div class="aspect-[4/3] bg-[#EAF4FF]">
                                <img
                                    src="{{ asset($member['image']) }}"
                                    alt="{{ $member['name'] }}"
                                    class="h-full w-full object-cover object-top"
                                    loading="lazy"
                                />
                            </div>
                            <div class="p-4">
                                <div class="font-semibold text-lg text-[#1B4A74]">{{ $member['name'] }}</div>
                                <div class="mt-1 text-xs font-semibold uppercase tracking-[0.12em] text-[#64809D]">{{ $member['role'] }}</div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection
