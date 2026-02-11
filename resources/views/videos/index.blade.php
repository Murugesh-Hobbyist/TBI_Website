@extends('layouts.site')

@section('title', 'Videos - '.config('twinbot.site.domain'))
@section('meta_description', 'Automation demos and results from TwinBot Innovations.')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10 pb-16">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">Videos</h1>
            <p class="mt-3 max-w-3xl text-sm text-[#364151]">
                Automation demos and results. Keep it clean, short, and proof-driven.
            </p>
        </div>

        @if (!($dbOk ?? true))
            <div class="mt-6 rounded-2xl border border-orange-400/30 bg-orange-50 px-4 py-3 text-sm text-orange-900">
                Database is not configured yet. Configure `DB_*` in `.env` and run migrations to publish videos.
            </div>
        @endif

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($videos as $v)
                <a href="{{ route('videos.show', $v) }}" class="group rounded-3xl border border-black/10 bg-white p-6 hover:bg-[#E7F6FF]">
                    <div class="text-xs font-semibold text-[#364151]">Video</div>
                    <div class="mt-2 font-semibold text-[#0F172A]">{{ $v->title }}</div>
                    @if ($v->summary)
                        <div class="mt-2 text-sm text-[#364151]">{{ \Illuminate\Support\Str::limit(strip_tags((string) $v->summary), 140) }}</div>
                    @endif
                    <div class="mt-3 text-sm font-semibold text-[#0067FF] group-hover:text-[#005EE9]">Watch</div>
                </a>
            @endforeach

            @if (($dbOk ?? true) && $videos->count() === 0)
                <div class="rounded-3xl border border-black/10 bg-white p-6 text-sm text-[#364151] md:col-span-3">
                    No published videos yet.
                </div>
            @endif
        </div>

        <div class="mt-8 text-sm text-[#364151]">
            {{ $videos->links() }}
        </div>
    </section>
@endsection

