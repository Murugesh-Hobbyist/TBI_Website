@extends('layouts.site')

@section('title', 'Projects | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <h1 class="font-display text-4xl tracking-tight">Projects</h1>
        <p class="mt-4 max-w-3xl text-white/70">Proof of execution. Publish only what you are proud to defend in a meeting.</p>

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($projects as $p)
                <a href="{{ route('projects.show', $p) }}" class="card p-6 hover:bg-white/10">
                    <div class="text-xs text-white/60">Project</div>
                    <div class="mt-2 font-semibold">{{ $p->title }}</div>
                    <div class="mt-2 text-sm text-white/65">{{ \Illuminate\Support\Str::limit(strip_tags((string) $p->summary), 140) }}</div>
                </a>
            @endforeach
        </div>

        <div class="mt-8 text-white/70">
            {{ $projects->links() }}
        </div>
    </section>
@endsection

