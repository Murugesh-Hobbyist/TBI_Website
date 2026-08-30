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
                        <div id="project-video-stage" class="relative aspect-video overflow-hidden rounded-2xl border border-[#C6DCEF] bg-[#122E53]">
                            <button
                                id="project-video-cover"
                                type="button"
                                class="group relative h-full w-full overflow-hidden text-left"
                                data-youtube-id="{{ $activeVideo['youtube_id'] }}"
                                data-title="{{ $activeVideo['title'] }}"
                                aria-label="Play {{ $activeVideo['title'] }}"
                            >
                                <img id="project-video-thumbnail" class="h-full w-full object-cover opacity-80 transition duration-300 group-hover:scale-[1.02] group-hover:opacity-95" src="https://i.ytimg.com/vi/{{ $activeVideo['youtube_id'] }}/hqdefault.jpg" alt="{{ $activeVideo['title'] }} video preview">
                                <span class="absolute inset-0 bg-gradient-to-t from-[#07192F]/70 via-transparent to-[#07192F]/20"></span>
                                <span class="absolute inset-0 flex items-center justify-center">
                                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white/95 pl-1 text-2xl text-[#1F6FD0] shadow-xl transition group-hover:scale-110" aria-hidden="true">&#9658;</span>
                                </span>
                                <span class="absolute bottom-5 left-5 rounded-full bg-[#122E53]/85 px-4 py-2 text-sm font-bold text-white">Play project video</span>
                            </button>
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
        function startProjectVideo(youtubeId, title) {
            var stage = document.getElementById('project-video-stage');
            if (!stage) return;

            stage.innerHTML = '';
            var player = document.createElement('iframe');
            player.id = 'project-video-player';
            player.className = 'h-full w-full';
            player.src = 'https://www.youtube-nocookie.com/embed/' + youtubeId + '?autoplay=1&controls=0&rel=0&modestbranding=1&iv_load_policy=3&playsinline=1&disablekb=1&enablejsapi=1&origin=' + encodeURIComponent(window.location.origin);
            player.title = title;
            player.frameBorder = '0';
            player.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
            player.referrerPolicy = 'strict-origin-when-cross-origin';
            player.allowFullscreen = true;
            stage.appendChild(player);

            var controls = document.createElement('div');
            controls.className = 'absolute inset-x-0 bottom-0 flex h-[74px] items-center justify-between gap-3 bg-[#0B2441] px-4 text-white shadow-[0_-12px_24px_rgba(11,36,65,0.5)] md:px-5';
            controls.innerHTML = '<div class="flex items-center gap-2"><button id="project-video-toggle" type="button" class="rounded-full bg-white/15 px-4 py-2 text-sm font-bold transition hover:bg-white/25" aria-label="Pause video" aria-pressed="true">Pause</button><button id="project-video-mute" type="button" class="rounded-full bg-white/15 px-4 py-2 text-sm font-bold transition hover:bg-white/25" aria-label="Mute video">Mute</button></div><button id="project-video-fullscreen" type="button" class="rounded-full border border-white/35 px-4 py-2 text-sm font-bold transition hover:bg-white/15" aria-label="View video fullscreen">Fullscreen</button>';
            stage.appendChild(controls);

            document.getElementById('project-video-toggle').addEventListener('click', function () {
                var isPlaying = this.getAttribute('aria-pressed') === 'true';
                sendYouTubeCommand(isPlaying ? 'pauseVideo' : 'playVideo');
                this.setAttribute('aria-pressed', String(!isPlaying));
                this.textContent = isPlaying ? 'Play' : 'Pause';
                this.setAttribute('aria-label', isPlaying ? 'Play video' : 'Pause video');
            });
            document.getElementById('project-video-mute').addEventListener('click', function () {
                var isMuted = this.getAttribute('aria-pressed') === 'true';
                sendYouTubeCommand(isMuted ? 'unMute' : 'mute');
                this.setAttribute('aria-pressed', String(!isMuted));
                this.textContent = isMuted ? 'Mute' : 'Unmute';
                this.setAttribute('aria-label', isMuted ? 'Mute video' : 'Unmute video');
            });
            document.getElementById('project-video-fullscreen').addEventListener('click', function () {
                if (stage.requestFullscreen) stage.requestFullscreen();
            });
        }

        function sendYouTubeCommand(command) {
            var player = document.getElementById('project-video-player');
            if (player && player.contentWindow) {
                player.contentWindow.postMessage(JSON.stringify({ event: 'command', func: command, args: [] }), 'https://www.youtube-nocookie.com');
            }
        }

        document.getElementById('project-video-cover')?.addEventListener('click', function () {
            startProjectVideo(this.dataset.youtubeId, this.dataset.title);
        });

        document.querySelectorAll('.project-video-card').forEach(function (card) {
            card.addEventListener('click', function () {
                startProjectVideo(card.dataset.youtubeId, card.dataset.title);
                document.getElementById('project-video-title').textContent = card.dataset.title;
                document.getElementById('project-video-summary').textContent = card.dataset.summary;
                document.getElementById('project-video-category').textContent = card.dataset.category;

                document.querySelectorAll('.project-video-card').forEach(function (item) {
                    item.classList.remove('ring-2', 'ring-[#1F6FD0]');
                });
                card.classList.add('ring-2', 'ring-[#1F6FD0]');
                document.getElementById('project-video-stage').closest('.tb-panel').scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });
    </script>
@endpush
