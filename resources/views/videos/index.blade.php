@extends('layouts.site')

@section('title', 'Videos | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <h1 class="font-display text-4xl tracking-tight">Videos</h1>
        <p class="mt-4 max-w-3xl text-white/70">Automation demos and results. Keep it clean, short, and proof-driven.</p>

        @if (!($dbOk ?? true))
            <div class="mt-6 rounded-2xl border border-orange-400/20 bg-orange-500/10 px-4 py-3 text-sm text-orange-100">
                Database is not configured yet. Configure `DB_*` in `.env` and run migrations to publish videos.
            </div>
        @endif

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($videos as $v)
                <a href="{{ route('videos.show', $v) }}" class="card p-6 hover:bg-white/10">
                    <div class="text-xs text-white/60">Video</div>
                    <div class="mt-2 font-semibold">{{ $v->title }}</div>
                    <div class="mt-2 text-sm text-white/65">{{ \Illuminate\Support\Str::limit(strip_tags((string) $v->summary), 140) }}</div>
                </a>
            @endforeach

            @if (($dbOk ?? true) && $videos->count() === 0)
                <div class="card p-6 text-sm text-white/60 md:col-span-3">
                    No published videos yet.
                </div>
            @endif
        </div>

        <div class="mt-8 text-white/70">
            {{ $videos->links() }}
        </div>
    </section>
@endsection
