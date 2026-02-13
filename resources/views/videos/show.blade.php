@extends('layouts.site')

@section('title', $video->title.' | TwinBot Innovations')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) ($video->summary ?: config('twinbot.site.tagline'))), 160))

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="tb-wrap">
            <a href="{{ route('videos.index') }}" class="text-sm font-semibold text-[#1F6FD0] hover:text-[#16589F]">&larr; Back to Videos</a>

            <article class="tb-panel p-6 md:p-10 mt-5 tb-reveal">
                <span class="tb-eyebrow">Video Case</span>
                <h1 class="tb-heading mt-4">{{ $video->title }}</h1>
                @if ($video->summary)
                    <p class="tb-lead mt-4 max-w-3xl">{{ $video->summary }}</p>
                @endif
            </article>

            <section class="tb-panel p-4 md:p-6 mt-5 tb-reveal">
                @if ($video->provider === 'youtube' && $video->provider_id)
                    <div class="aspect-video w-full overflow-hidden rounded-2xl border border-[#C6DCEF] bg-[#F3FAFF]">
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
                    <div class="aspect-video w-full overflow-hidden rounded-2xl border border-[#C6DCEF] bg-[#F3FAFF]">
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
                    <div class="rounded-2xl border border-[#C6DCEF] bg-[#F3FAFF] p-4 text-sm text-[#4F6890]">
                        Configure provider and provider_id in Admin.
                    </div>
                @endif
            </section>
        </div>
    </section>
@endsection


