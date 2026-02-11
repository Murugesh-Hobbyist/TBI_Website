@extends('layouts.site')

@section('title', 'Home - '.config('twinbot.site.domain'))
@section('meta_description', 'Say goodbye to PLCs. Step into the future with ECS (Embedded Control Systems).')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10">
        <div class="relative overflow-hidden rounded-3xl border border-black/10 bg-white">
            <div class="absolute inset-0">
                <img src="{{ asset(config('twinbot.assets.hero_image')) }}" alt="" class="h-full w-full object-cover opacity-25" />
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/85 to-white/30"></div>
            </div>

            <div class="relative grid gap-8 p-8 md:grid-cols-2 md:items-center md:p-12">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-black/10 bg-[#E7F6FF] px-4 py-2 text-xs font-semibold text-[#0F172A]">
                        Embedded Control Systems (ECS)
                    </div>
                    <h1 class="mt-5 font-display text-4xl tracking-tight text-[#0F172A] md:text-5xl">
                        Say Goodbye to PLCs
                        <span class="block text-[#0067FF]">Step into the Future with ECS</span>
                        <span class="block text-lg font-semibold text-[#364151] md:text-xl">(Embedded Control Systems!)</span>
                    </h1>
                    <p class="mt-5 max-w-xl text-base text-[#364151]">
                        Unlock the potential of automation. Leave PLCs behind and embrace robust, reliable, and versatile embedded control systems.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Explore Products</a>
                        <a href="{{ route('contact') }}" class="btn btn-ghost">Request a Quote</a>
                    </div>
                </div>

                <div class="rounded-2xl border border-black/10 bg-white/80 p-6">
                    <div class="text-xs font-semibold text-[#364151]">Why ECS</div>
                    <p class="mt-3 text-sm text-[#364151]">
                        PLCs are powerful but often come with high cost, rigid architectures, and unnecessary complexity for many applications.
                        ECS delivers flexibility, precision, and seamless integration with modern technologies.
                    </p>
                    <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-xl border border-black/10 bg-white px-4 py-3">
                            <div class="font-semibold text-[#0F172A]">Cost Effective</div>
                            <div class="mt-1 text-xs text-[#364151]">Tailored to needs</div>
                        </div>
                        <div class="rounded-xl border border-black/10 bg-white px-4 py-3">
                            <div class="font-semibold text-[#0F172A]">Scalable</div>
                            <div class="mt-1 text-xs text-[#364151]">Grows with demand</div>
                        </div>
                        <div class="rounded-xl border border-black/10 bg-white px-4 py-3">
                            <div class="font-semibold text-[#0F172A]">Modern Integration</div>
                            <div class="mt-1 text-xs text-[#364151]">IoT, AI, sensors</div>
                        </div>
                        <div class="rounded-xl border border-black/10 bg-white px-4 py-3">
                            <div class="font-semibold text-[#0F172A]">Reliable</div>
                            <div class="mt-1 text-xs text-[#364151]">Industrial ready</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto mt-12 max-w-6xl px-4">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
            <h2 class="font-display text-2xl text-[#0F172A]">PLC Limiters vs ECS Potential</h2>
            <p class="mt-2 text-sm text-[#364151]">A practical comparison across the aspects that matter.</p>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 overflow-hidden rounded-2xl border border-black/10">
                    <thead class="bg-[#0F172A] text-white">
                        <tr class="text-left text-sm">
                            <th class="px-4 py-3 font-semibold">Aspect</th>
                            <th class="px-4 py-3 font-semibold">Programmable Logic Controller (PLC)</th>
                            <th class="px-4 py-3 font-semibold">Embedded Control System (ECS)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-sm">
                        @foreach (config('twinbot.home.plc_vs_ecs', []) as $row)
                            <tr class="border-t border-black/10">
                                <td class="px-4 py-4 font-semibold text-[#0F172A]">{{ $row['aspect'] }}</td>
                                <td class="px-4 py-4 text-[#364151]">{{ $row['plc'] }}</td>
                                <td class="px-4 py-4 text-[#364151]">{{ $row['ecs'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="mx-auto mt-12 max-w-6xl px-4">
        <div class="grid gap-6 md:grid-cols-2 md:items-start">
            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
                <h2 class="font-display text-2xl text-[#0F172A]">Introducing Sail OS</h2>
                <p class="mt-3 text-sm text-[#364151]">
                    Sail OS is a custom-built operating system designed for industrial automation. It brings clarity to manufacturing data,
                    turning complex signals into actionable insights.
                </p>
                <ul class="mt-5 space-y-2 text-sm text-[#364151]">
                    <li><span class="font-semibold text-[#0F172A]">Customizable interface:</span> tailor panels to your factory needs.</li>
                    <li><span class="font-semibold text-[#0F172A]">Immersive HDMI support:</span> high-resolution insights on external displays.</li>
                    <li><span class="font-semibold text-[#0F172A]">Real-time dashboards:</span> troubleshoot faster and reduce downtime.</li>
                    <li><span class="font-semibold text-[#0F172A]">Data logging and reporting:</span> track history and improve decisions.</li>
                    <li><span class="font-semibold text-[#0F172A]">Device integration:</span> unify sensors and industrial devices.</li>
                    <li><span class="font-semibold text-[#0F172A]">Scalable and energy-efficient:</span> optimize cost and sustainability.</li>
                </ul>
            </div>

            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
                <h2 class="font-display text-2xl text-[#0F172A]">Key Features</h2>
                <p class="mt-3 text-sm text-[#364151]">Designed for reliability, usability, and modern integration.</p>
                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    @foreach ([
                        ['t' => 'Seamless Integration', 'd' => 'Smooth communication across systems.'],
                        ['t' => 'Easy to use', 'd' => 'User-friendly UI and workflows.'],
                        ['t' => 'Cross Compatibility', 'd' => 'Works with existing setups when needed.'],
                        ['t' => 'Scalable', 'd' => 'Expand and adapt as operations grow.'],
                        ['t' => 'Secure', 'd' => 'Protect sensitive data and safe operations.'],
                    ] as $f)
                        <div class="rounded-2xl border border-black/10 bg-[#E7F6FF] p-4">
                            <div class="font-semibold text-[#0F172A]">{{ $f['t'] }}</div>
                            <div class="mt-1 text-xs text-[#364151]">{{ $f['d'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto mt-12 max-w-6xl px-4">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
            <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="font-display text-2xl text-[#0F172A]">Products</h2>
                    <p class="mt-2 text-sm text-[#364151]">Measurement, inspection, and embedded automation products.</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#0067FF] hover:text-[#005EE9]">View all</a>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                @foreach (($featuredProducts ?? collect()) as $p)
                    @php
                        $img = $p['image'] ?? null;
                        $src = $img && \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : ($img ? asset($img) : null);
                    @endphp
                    <a href="{{ route('products.show', ['product' => $p['slug']]) }}" class="group overflow-hidden rounded-2xl border border-black/10 bg-white hover:bg-[#E7F6FF]">
                        @if ($src)
                            <div class="h-44 w-full bg-white">
                                <img src="{{ $src }}" alt="" class="h-full w-full object-contain p-4 transition-transform duration-200 group-hover:scale-[1.02]" />
                            </div>
                        @endif
                        <div class="px-5 pb-5 pt-4">
                            <div class="text-xs font-semibold text-[#364151]">{{ $p['series'] ?? 'Product' }}</div>
                            <div class="mt-1 font-semibold text-[#0F172A]">{{ $p['title'] }}</div>
                            @if (!empty($p['summary']))
                                <div class="mt-2 text-sm text-[#364151]">{{ \Illuminate\Support\Str::limit(strip_tags((string) $p['summary']), 130) }}</div>
                            @endif
                            <div class="mt-3 text-sm font-semibold text-[#0067FF]">Read more</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto mt-12 max-w-6xl px-4 pb-16">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
            <h2 class="font-display text-2xl text-[#0F172A]">Trusted by below companies</h2>
            <div class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach (config('twinbot.assets.trusted_logos', []) as $logo)
                    <div class="flex items-center justify-center rounded-2xl border border-black/10 bg-white p-4">
                        <img src="{{ asset($logo) }}" alt="" class="max-h-12 w-auto object-contain" />
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-10 grid gap-4 md:grid-cols-3">
            @foreach ([
                ['n' => '01', 't' => 'Connect', 'd' => 'Share your requirements and desired features. We design a tailored solution.'],
                ['n' => '02', 't' => 'Integrate', 'd' => 'We integrate seamlessly into your existing setup with minimal disruption.'],
                ['n' => '03', 't' => 'Streamline', 'd' => 'Standardize operations to improve quality, delivery, and efficiency.'],
            ] as $step)
                <div class="rounded-3xl border border-black/10 bg-white p-6">
                    <div class="text-xs font-semibold text-[#364151]">{{ $step['n'] }}</div>
                    <div class="mt-2 font-display text-xl text-[#0F172A]">{{ $step['t'] }}</div>
                    <div class="mt-2 text-sm text-[#364151]">{{ $step['d'] }}</div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

