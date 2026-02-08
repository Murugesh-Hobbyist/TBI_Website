@extends('layouts.site')

@section('title', $video->title.' | Videos | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <a href="{{ route('videos.index') }}" class="text-sm text-white/70 hover:text-white">← Back to Videos</a>
        <h1 class="mt-4 font-display text-4xl tracking-tight">{{ $video->title }}</h1>
        @if ($video->summary)
            <p class="mt-4 max-w-3xl text-white/70">{{ $video->summary }}</p>
        @endif

        <div class="mt-10 card p-4">
            @if ($video->provider === 'youtube' && $video->provider_id)
                <div class="aspect-video w-full overflow-hidden rounded-xl border border-white/10">
                    <iframe
                        class="h-full w-full"
                        src="https://www.youtube-nocookie.com/embed/{{ $video->provider_id }}"
                        title="{{ $video->title }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            @elseif ($video->provider === 'vimeo' && $video->provider_id)
                <div class="aspect-video w-full overflow-hidden rounded-xl border border-white/10">
                    <iframe
                        class="h-full w-full"
                        src="https://player.vimeo.com/video/{{ $video->provider_id }}"
                        title="{{ $video->title }}"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            @else
                <div class="p-4 text-sm text-white/70">
                    Configure provider + provider_id in Admin.
                </div>
            @endif
        </div>
    </section>
@endsection

