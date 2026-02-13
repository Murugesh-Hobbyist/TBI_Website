@extends('layouts.site')

@section('title', $project->title.' | TwinBot Innovations')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) ($project->summary ?: config('twinbot.site.tagline'))), 160))

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="tb-wrap">
            <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-[#1F6FD0] hover:text-[#16589F]">&larr; Back to Projects</a>

            <article class="tb-panel p-6 md:p-10 mt-5 tb-reveal">
                <span class="tb-eyebrow">Project Case</span>
                <h1 class="tb-heading mt-4">{{ $project->title }}</h1>
                @if ($project->summary)
                    <p class="tb-lead mt-4 max-w-3xl">{{ $project->summary }}</p>
                @endif
            </article>

            @if ($project->body)
                <section class="tb-panel p-6 md:p-8 mt-5 tb-reveal">
                    <h2 class="tb-subheading">Overview</h2>
                    <p class="mt-4 whitespace-pre-wrap text-sm leading-relaxed text-[#4F6890]">{{ $project->body }}</p>
                </section>
            @endif

            @if ($project->media->count())
                <section class="tb-panel p-6 md:p-8 mt-5 tb-reveal">
                    <h2 class="tb-subheading">Project Media</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-3">
                        @foreach ($project->media as $media)
                            <article class="tb-card">
                                <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">{{ strtoupper($media->type) }}</div>
                                @if ($media->title)
                                    <h3 class="mt-2 font-semibold text-[#1B4A74]">{{ $media->title }}</h3>
                                @endif

                                @if ($media->type === 'image' && $media->path)
                                    <div class="tb-product-thumb mt-3 h-52">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($media->path) }}" alt="Project media" class="h-full w-full object-cover rounded-lg" />
                                    </div>
                                @elseif ($media->external_url)
                                    <p class="mt-3 break-words text-sm text-[#4F6890]">{{ $media->external_url }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>
@endsection


