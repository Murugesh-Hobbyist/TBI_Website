@extends('layouts.site')

@section('title', $project->title.' - '.config('twinbot.site.domain'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) ($project->summary ?: config('twinbot.site.tagline'))), 160))

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10 pb-16">
        <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-[#0067FF] hover:text-[#005EE9]">&lt;- Back to Projects</a>

        <div class="mt-6 rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <div class="text-xs font-semibold text-[#364151]">Project</div>
            <h1 class="mt-2 font-display text-4xl tracking-tight text-[#0F172A]">{{ $project->title }}</h1>
            @if ($project->summary)
                <p class="mt-4 max-w-3xl text-sm text-[#364151]">{{ $project->summary }}</p>
            @endif
        </div>

        @if ($project->body)
            <div class="mt-6 rounded-3xl border border-black/10 bg-white p-6 md:p-8">
                <h2 class="font-display text-2xl text-[#0F172A]">Overview</h2>
                <div class="mt-4 whitespace-pre-wrap text-sm text-[#364151]">{{ $project->body }}</div>
            </div>
        @endif

        @if ($project->media->count())
            <div class="mt-10">
                <h2 class="font-display text-2xl text-[#0F172A]">Media</h2>
                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    @foreach ($project->media as $m)
                        <div class="overflow-hidden rounded-3xl border border-black/10 bg-white">
                            <div class="p-4">
                                <div class="text-xs font-semibold text-[#364151]">{{ strtoupper($m->type) }}</div>
                                @if ($m->title)
                                    <div class="mt-1 font-semibold text-[#0F172A]">{{ $m->title }}</div>
                                @endif
                            </div>
                            @if ($m->type === 'image' && $m->path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($m->path) }}" alt="" class="h-56 w-full object-cover" />
                            @elseif ($m->external_url)
                                <div class="p-4 text-sm text-[#364151] break-words">{{ $m->external_url }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection

