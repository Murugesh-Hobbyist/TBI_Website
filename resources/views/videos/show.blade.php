@extends('layouts.site')

@section('title', $video->title.' - '.config('twinbot.site.domain'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) ($video->summary ?: config('twinbot.site.tagline'))), 160))

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10 pb-16">
        <a href="{{ route('videos.index') }}" class="text-sm font-semibold text-[#0067FF] hover:text-[#005EE9]">&lt;- Back to Videos</a>

        <div class="mt-6 rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <div class="text-xs font-semibold text-[#364151]">Video</div>
            <h1 class="mt-2 font-display text-4xl tracking-tight text-[#0F172A]">{{ $video->title }}</h1>
            @if ($video->summary)
                <p class="mt-4 max-w-3xl text-sm text-[#364151]">{{ $video->summary }}</p>
            @endif
        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-black/10 bg-white p-4">
            @if ($video->provider === 'youtube' && $video->provider_id)
                <div class="aspect-video w-full overflow-hidden rounded-2xl border border-black/10">
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
                <div class="aspect-video w-full overflow-hidden rounded-2xl border border-black/10">
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
                <div class="p-4 text-sm text-[#364151]">
                    Configure provider and provider_id in Admin.
                </div>
            @endif
        </div>
    </section>
@endsection

