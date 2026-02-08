@extends('layouts.site')

@section('title', $project->title.' | Projects | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <a href="{{ route('projects.index') }}" class="text-sm text-white/70 hover:text-white">← Back to Projects</a>
        <h1 class="mt-4 font-display text-4xl tracking-tight">{{ $project->title }}</h1>
        @if ($project->summary)
            <p class="mt-4 max-w-3xl text-white/70">{{ $project->summary }}</p>
        @endif

        @if ($project->body)
            <div class="mt-10 card p-6">
                <h2 class="font-display text-2xl">Overview</h2>
                <div class="mt-4 whitespace-pre-wrap text-sm text-white/75">{{ $project->body }}</div>
            </div>
        @endif

        @if ($project->media->count())
            <div class="mt-12">
                <h2 class="font-display text-2xl">Media</h2>
                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    @foreach ($project->media as $m)
                        <div class="card overflow-hidden">
                            <div class="p-4">
                                <div class="text-xs text-white/60">{{ strtoupper($m->type) }}</div>
                                @if ($m->title)
                                    <div class="mt-1 font-semibold">{{ $m->title }}</div>
                                @endif
                            </div>
                            @if ($m->type === 'image' && $m->path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($m->path) }}" alt="" class="h-56 w-full object-cover" />
                            @elseif ($m->external_url)
                                <div class="p-4 text-sm text-white/70 break-words">{{ $m->external_url }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
