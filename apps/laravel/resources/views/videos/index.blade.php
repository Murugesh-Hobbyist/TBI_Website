@extends('layouts.site')

@section('title', 'Videos | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <h1 class="font-display text-4xl tracking-tight">Videos</h1>
        <p class="mt-4 max-w-3xl text-white/70">Automation demos and results. Keep it clean, short, and proof-driven.</p>

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($videos as $v)
                <a href="{{ route('videos.show', $v) }}" class="card p-6 hover:bg-white/10">
                    <div class="text-xs text-white/60">Video</div>
                    <div class="mt-2 font-semibold">{{ $v->title }}</div>
                    <div class="mt-2 text-sm text-white/65">{{ \Illuminate\Support\Str::limit(strip_tags((string) $v->summary), 140) }}</div>
                </a>
            @endforeach
        </div>

        <div class="mt-8 text-white/70">
            {{ $videos->links() }}
        </div>
    </section>
@endsection

