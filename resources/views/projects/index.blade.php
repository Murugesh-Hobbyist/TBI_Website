@extends('layouts.site')

@section('title', 'Projects | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <h1 class="font-display text-4xl tracking-tight">Projects</h1>
        <p class="mt-4 max-w-3xl text-white/70">Proof of execution. Publish only what you are proud to defend in a meeting.</p>

        @if (!($dbOk ?? true))
            <div class="mt-6 rounded-2xl border border-orange-400/20 bg-orange-500/10 px-4 py-3 text-sm text-orange-100">
                Database is not configured yet. Configure `DB_*` in `.env` and run migrations to publish projects.
            </div>
        @endif

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($projects as $p)
                <a href="{{ route('projects.show', $p) }}" class="card p-6 hover:bg-white/10">
                    <div class="text-xs text-white/60">Project</div>
                    <div class="mt-2 font-semibold">{{ $p->title }}</div>
                    <div class="mt-2 text-sm text-white/65">{{ \Illuminate\Support\Str::limit(strip_tags((string) $p->summary), 140) }}</div>
                </a>
            @endforeach

            @if (($dbOk ?? true) && $projects->count() === 0)
                <div class="card p-6 text-sm text-white/60 md:col-span-3">
                    No published projects yet.
                </div>
            @endif
        </div>

        <div class="mt-8 text-white/70">
            {{ $projects->links() }}
        </div>
    </section>
@endsection
