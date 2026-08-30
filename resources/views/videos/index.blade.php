@extends('layouts.site')

@section('title', 'Videos | TwinBot Innovations')
@section('meta_description', 'Watch TwinBot demos, deployment snippets, and automation walkthrough videos.')

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Video Library</span>
                <h1 class="tb-heading mt-4">TwinBot projects, shown in action.</h1>
                <p class="tb-lead mt-5 max-w-3xl">Watch each YouTube project video directly on TwinBot. Select a project to play it here and read the automation outcome beside it.</p>
            </div>

            @if ($videos->isEmpty())
                <div class="tb-panel mt-5 p-6 text-sm leading-relaxed text-[#4F6890] tb-reveal">
                    Project videos will appear here shortly. Add YouTube video IDs to <code>config/twinbot.php</code> under <code>videos</code>, or publish videos from the Admin area when the database is configured.
                </div>
            @else
                @php($activeVideo = $videos->first())
                <div class="mt-5 grid gap-5 lg:grid-cols-[minmax(0,1.35fr)_minmax(300px,0.65fr)]">
                    <div class="tb-panel overflow-hidden p-3 md:p-4 tb-reveal">
                        <div class="aspect-video overflow-hidden rounded-2xl border border-[#C6DCEF] bg-[#F3FAFF]">
                            <iframe
                                id="project-video-player"
                                class="h-full w-full"
                                src="https://www.youtube-nocookie.com/embed/{{ $activeVideo['youtube_id'] }}?autoplay=0&controls=0&rel=0&modestbranding=1&iv_load_policy=3&playsinline=1&disablekb=1"
                                title="{{ $activeVideo['title'] }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </div>

                    <aside class="tb-panel p-6 md:p-8 tb-reveal" aria-live="polite">
                        <div id="project-video-category" class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">{{ $activeVideo['category'] }}</div>
                        <h2 id="project-video-title" class="font-display mt-3 text-3xl text-[#122E53]">{{ $activeVideo['title'] }}</h2>
                        <p id="project-video-summary" class="mt-4 text-sm leading-relaxed text-[#4F6890]">{{ $activeVideo['summary'] }}</p>
                        <div class="mt-6 border-t border-[#D8E6F4] pt-5">
                            <div class="text-sm font-bold text-[#173E69]">Need a similar automation solution?</div>
                            <a href="{{ route('contact') }}" class="btn btn-primary mt-3">Discuss your project</a>
                        </div>
                    </aside>
                </div>

                <div class="mt-8">
                    <div class="flex flex-wrap items-end justify-between gap-3">
                        <div>
                            <span class="tb-eyebrow">Project Playlist</span>
                            <h2 class="tb-subheading mt-2">Select a project video</h2>
                        </div>
                        <p class="text-sm text-[#4F6890]">All videos play here on TwinBot.</p>
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($videos as $index => $video)
                            <button
                                type="button"
                                class="project-video-card tb-card text-left tb-reveal {{ $index === 0 ? 'ring-2 ring-[#1F6FD0]' : '' }}"
                                data-youtube-id="{{ $video['youtube_id'] }}"
                                data-title="{{ $video['title'] }}"
                                data-summary="{{ $video['summary'] }}"
                                data-category="{{ $video['category'] }}"
                            >
                                <div class="flex items-center justify-between gap-3">
                                    <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">{{ $video['category'] }}</div>
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#E7F4FF] text-[#1F6FD0]" aria-hidden="true">&#9658;</span>
                                </div>
                                <h3 class="mt-3 font-display text-xl text-[#122E53]">{{ $video['title'] }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">{{ \Illuminate\Support\Str::limit($video['summary'], 130) }}</p>
                                <div class="mt-4 text-sm font-bold text-[#1F6FD0]">Play on TwinBot</div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.project-video-card').forEach(function (card) {
            card.addEventListener('click', function () {
                var player = document.getElementById('project-video-player');
                if (!player) return;

                player.src = 'https://www.youtube-nocookie.com/embed/' + card.dataset.youtubeId + '?autoplay=1&controls=0&rel=0&modestbranding=1&iv_load_policy=3&playsinline=1&disablekb=1';
                player.title = card.dataset.title;
                document.getElementById('project-video-title').textContent = card.dataset.title;
                document.getElementById('project-video-summary').textContent = card.dataset.summary;
                document.getElementById('project-video-category').textContent = card.dataset.category;

                document.querySelectorAll('.project-video-card').forEach(function (item) {
                    item.classList.remove('ring-2', 'ring-[#1F6FD0]');
                });
                card.classList.add('ring-2', 'ring-[#1F6FD0]');
                player.closest('.tb-panel').scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });
    </script>
@endpush
