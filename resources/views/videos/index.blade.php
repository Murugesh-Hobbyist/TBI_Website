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
        var projectPlayer;
        var projectPlayerTimer;
        var youtubeApiPromise;
        var projectControlsTimer;

        function loadYouTubeApi() {
            if (window.YT && window.YT.Player) return Promise.resolve();
            if (youtubeApiPromise) return youtubeApiPromise;

            youtubeApiPromise = new Promise(function (resolve) {
                window.onYouTubeIframeAPIReady = resolve;
                var script = document.createElement('script');
                script.src = 'https://www.youtube.com/iframe_api';
                document.head.appendChild(script);
            });
            return youtubeApiPromise;
        }

        function formatVideoTime(seconds) {
            seconds = Math.max(0, Math.floor(seconds || 0));
            var minutes = Math.floor(seconds / 60);
            var remainingSeconds = String(seconds % 60).padStart(2, '0');
            return minutes + ':' + remainingSeconds;
        }

        function startProjectVideo(youtubeId, title) {
            var stage = document.getElementById('project-video-stage');
            if (!stage) return;

            if (projectPlayerTimer) window.clearInterval(projectPlayerTimer);
            if (projectControlsTimer) window.clearTimeout(projectControlsTimer);
            projectControlsTimer = null;
            if (projectPlayer && projectPlayer.destroy) projectPlayer.destroy();
            projectPlayer = null;
            stage.innerHTML = '';
            stage.innerHTML = '<div id="project-video-player" class="h-full w-full"></div><button id="project-video-surface" type="button" class="absolute inset-0 z-10 cursor-pointer" aria-label="Pause video"></button><div id="project-video-controls" class="pointer-events-none absolute inset-x-0 bottom-0 z-20 h-[58px] bg-[#0B2441] opacity-0 transition-opacity duration-200 md:h-[64px]"><div class="flex h-full items-center gap-3 px-3 text-white md:px-4"><button id="project-video-restart" type="button" class="pointer-events-auto inline-flex h-8 w-8 shrink-0 items-center justify-center rounded text-lg text-white/90 transition hover:bg-white/15 hover:text-white" aria-label="Restart video" title="Restart">↺</button><span id="project-video-time" class="shrink-0 text-xs font-bold tabular-nums">0:00 / 0:00</span><input id="project-video-progress" class="pointer-events-auto h-1.5 min-w-0 flex-1 cursor-pointer accent-[#FF0000]" type="range" min="0" max="0" value="0" step="0.1" aria-label="Video progress"><div class="relative flex h-8 w-8 shrink-0 items-center justify-center"><input id="project-video-volume" class="pointer-events-auto absolute bottom-full left-1/2 mb-3 h-24 w-1 -translate-x-1/2 cursor-pointer accent-[#FF0000]" type="range" min="0" max="100" value="100" step="1" aria-label="Video volume" style="writing-mode: vertical-lr; direction: rtl;"><button id="project-video-mute" type="button" class="pointer-events-auto inline-flex h-8 w-8 items-center justify-center rounded text-base text-white/90 transition hover:bg-white/15 hover:text-white" aria-label="Mute video" aria-pressed="false" title="Mute">🔊</button></div><button id="project-video-captions" type="button" class="pointer-events-auto rounded px-2 py-1 text-xs font-extrabold text-white/80 transition hover:bg-white/15 hover:text-white" aria-label="Turn captions on" aria-pressed="false">CC</button><button id="project-video-fullscreen" type="button" class="pointer-events-auto inline-flex h-8 w-8 shrink-0 items-center justify-center rounded text-xl text-white/90 transition hover:bg-white/15 hover:text-white" aria-label="Enter fullscreen" title="Fullscreen">⛶</button></div></div>';

            var controls = document.getElementById('project-video-controls');
            var surface = document.getElementById('project-video-surface');
            var progress = document.getElementById('project-video-progress');
            var time = document.getElementById('project-video-time');
            var restart = document.getElementById('project-video-restart');
            var mute = document.getElementById('project-video-mute');
            var volume = document.getElementById('project-video-volume');
            var captions = document.getElementById('project-video-captions');
            var fullscreen = document.getElementById('project-video-fullscreen');
            var captionsEnabled = false;

            function showControls() {
                controls.classList.remove('pointer-events-none', 'opacity-0');
                controls.classList.add('pointer-events-auto', 'opacity-100');
            }

            function hideControls() {
                controls.classList.remove('pointer-events-auto', 'opacity-100');
                controls.classList.add('pointer-events-none', 'opacity-0');
            }

            function showControlsForSixSeconds() {
                showControls();
                window.clearTimeout(projectControlsTimer);
                projectControlsTimer = window.setTimeout(function () {
                    projectControlsTimer = null;
                    hideControls();
                }, 6000);
            }

            stage.addEventListener('mouseenter', showControls);
            stage.addEventListener('mouseleave', function () {
                if (!projectControlsTimer) hideControls();
            });
            stage.addEventListener('click', showControlsForSixSeconds, true);

            surface.addEventListener('click', function () {
                if (!projectPlayer || !window.YT) return;
                if (projectPlayer.getPlayerState() === window.YT.PlayerState.PLAYING) {
                    projectPlayer.pauseVideo();
                    surface.setAttribute('aria-label', 'Play video');
                } else {
                    projectPlayer.playVideo();
                    surface.setAttribute('aria-label', 'Pause video');
                }
            });

            progress.addEventListener('input', function () {
                if (projectPlayer) projectPlayer.seekTo(Number(this.value), true);
            });

            restart.addEventListener('click', function () {
                if (!projectPlayer) return;
                projectPlayer.seekTo(0, true);
                projectPlayer.playVideo();
                surface.setAttribute('aria-label', 'Pause video');
            });

            mute.addEventListener('click', function () {
                if (!projectPlayer) return;
                var isMuted = projectPlayer.isMuted();
                if (isMuted) {
                    if (Number(volume.value) === 0) volume.value = 100;
                    projectPlayer.setVolume(Number(volume.value));
                    projectPlayer.unMute();
                } else {
                    projectPlayer.mute();
                }
                mute.setAttribute('aria-pressed', String(!isMuted));
                mute.setAttribute('aria-label', isMuted ? 'Mute video' : 'Unmute video');
                mute.title = isMuted ? 'Mute' : 'Unmute';
                mute.textContent = isMuted ? '🔊' : '🔇';
            });

            volume.addEventListener('input', function () {
                if (!projectPlayer) return;
                var newVolume = Number(this.value);
                projectPlayer.setVolume(newVolume);
                if (newVolume === 0) {
                    projectPlayer.mute();
                } else {
                    projectPlayer.unMute();
                }
                mute.setAttribute('aria-pressed', String(newVolume === 0));
                mute.setAttribute('aria-label', newVolume === 0 ? 'Unmute video' : 'Mute video');
                mute.title = newVolume === 0 ? 'Unmute' : 'Mute';
                mute.textContent = newVolume === 0 ? '🔇' : '🔊';
            });

            captions.addEventListener('click', function () {
                if (!projectPlayer) return;
                captionsEnabled = !captionsEnabled;
                projectPlayer.loadModule('captions');
                projectPlayer.setOption('captions', 'track', captionsEnabled ? { languageCode: 'en' } : {});
                captions.setAttribute('aria-pressed', String(captionsEnabled));
                captions.setAttribute('aria-label', captionsEnabled ? 'Turn captions off' : 'Turn captions on');
                captions.classList.toggle('bg-white/20', captionsEnabled);
                captions.classList.toggle('text-white', captionsEnabled);
            });

            fullscreen.addEventListener('click', function () {
                if (document.fullscreenElement) {
                    document.exitFullscreen?.();
                } else {
                    stage.requestFullscreen?.();
                }
            });

            showControlsForSixSeconds();

            loadYouTubeApi().then(function () {
                projectPlayer = new window.YT.Player('project-video-player', {
                    host: 'https://www.youtube-nocookie.com',
                    videoId: youtubeId,
                    width: '100%',
                    height: '100%',
                    playerVars: {
                        autoplay: 1,
                        controls: 0,
                        rel: 0,
                        modestbranding: 1,
                        iv_load_policy: 3,
                        playsinline: 1,
                        disablekb: 1,
                        cc_load_policy: 0,
                        origin: window.location.origin
                    },
                    events: {
                        onReady: function (event) {
                            event.target.playVideo();
                            projectPlayerTimer = window.setInterval(function () {
                                var duration = event.target.getDuration();
                                var current = event.target.getCurrentTime();
                                progress.max = duration || 0;
                                progress.value = current || 0;
                                time.textContent = formatVideoTime(current) + ' / ' + formatVideoTime(duration);
                            }, 250);
                        },
                        onStateChange: function (event) {
                            surface.setAttribute('aria-label', event.data === window.YT.PlayerState.PLAYING ? 'Pause video' : 'Play video');
                        }
                    }
                });
            });
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
