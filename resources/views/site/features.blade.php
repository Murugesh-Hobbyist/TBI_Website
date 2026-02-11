@extends('layouts.site')

@section('title', 'Features - '.config('twinbot.site.domain'))
@section('meta_description', 'All of what your business needs in one space.')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">Features</h1>
            <p class="mt-3 max-w-3xl text-sm text-[#364151]">
                All of what your business needs in one space. Build automation that is accessible, scalable, and secure.
            </p>
        </div>
    </section>

    <section class="mx-auto mt-8 max-w-6xl px-4">
        <div class="grid gap-4 md:grid-cols-3">
            @foreach ([
                ['t' => 'Seamless Integration', 'd' => 'Enable smooth communication across systems without disruptions.'],
                ['t' => 'Easy to use', 'd' => 'User-friendly interfaces that reduce training time.'],
                ['t' => 'Cross Compatibility', 'd' => 'Designed to integrate with existing systems when required.'],
                ['t' => 'Scalable', 'd' => 'Expand and adapt automation as operations grow.'],
                ['t' => 'Secure', 'd' => 'Protect data and ensure safe operations across processes.'],
                ['t' => 'Accessible through all devices', 'd' => 'Optional capabilities for wireless monitoring and control.'],
            ] as $f)
                <div class="rounded-3xl border border-black/10 bg-white p-6">
                    <div class="font-display text-xl text-[#0F172A]">{{ $f['t'] }}</div>
                    <div class="mt-2 text-sm text-[#364151]">{{ $f['d'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto mt-8 max-w-6xl px-4 pb-16">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
            <h2 class="font-display text-2xl text-[#0F172A]">Operational Benefits</h2>
            <p class="mt-2 text-sm text-[#364151]">
                Practical features that support reliability, deployment, and day-to-day maintenance.
            </p>
            <div class="mt-6 grid gap-3 sm:grid-cols-2 md:grid-cols-4">
                @foreach ([
                    'One Click Setup',
                    'Malware Protection',
                    '24/7 Technical Support',
                    'Multiple Administrators',
                ] as $b)
                    <div class="rounded-2xl border border-black/10 bg-[#E7F6FF] p-4 text-sm font-semibold text-[#0F172A]">
                        {{ $b }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

