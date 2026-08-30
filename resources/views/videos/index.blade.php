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
                @foreach ($videos as $video)
                    <article class="mt-5 grid gap-5 lg:grid-cols-[minmax(0,1.35fr)_minmax(300px,0.65fr)]">
                        <div class="tb-panel overflow-hidden p-3 md:p-4 tb-reveal">
                            <div class="project-video-stage relative aspect-video overflow-hidden rounded-2xl border border-[#C6DCEF] bg-[#122E53]" data-youtube-id="{{ $video['youtube_id'] }}" data-title="{{ $video['title'] }}">
                                <button type="button" class="project-video-cover group relative h-full w-full overflow-hidden text-left" aria-label="Play {{ $video['title'] }}">
                                    <img class="h-full w-full object-cover opacity-80 transition duration-300 group-hover:scale-[1.02] group-hover:opacity-95" src="https://i.ytimg.com/vi/{{ $video['youtube_id'] }}/hqdefault.jpg" alt="{{ $video['title'] }} video preview">
                                    <span class="absolute inset-0 bg-gradient-to-t from-[#07192F]/70 via-transparent to-[#07192F]/20"></span>
                                    <span class="absolute inset-0 flex items-center justify-center"><span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white/95 pl-1 text-2xl text-[#1F6FD0] shadow-xl transition group-hover:scale-110" aria-hidden="true">&#9658;</span></span>
                                    <span class="absolute bottom-5 left-5 rounded-full bg-[#122E53]/85 px-4 py-2 text-sm font-bold text-white">Play project video</span>
                                </button>
                            </div>
                        </div>
                        <div class="tb-panel p-6 md:p-8 tb-reveal">
                            <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">{{ $video['category'] }}</div>
                            <h2 class="font-display mt-3 text-3xl text-[#122E53]">{{ $video['title'] }}</h2>
                            <p class="mt-4 text-sm leading-relaxed text-[#4F6890]">{{ $video['summary'] }}</p>
                        </div>
                    </article>
                @endforeach
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var youtubeApiPromise;

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

        function startProjectVideo(stage) {
            var state = { player: null, timer: null, controlsTimer: null, captionsEnabled: false };
            stage.innerHTML = '<div class="project-video-player h-full w-full"></div><button type="button" class="project-video-surface absolute inset-0 z-10 cursor-pointer" aria-label="Pause video"></button><div class="project-video-controls pointer-events-none absolute inset-x-0 bottom-0 z-20 h-[58px] bg-[#0B2441] opacity-0 transition-opacity duration-200 md:h-[64px]"><div class="flex h-full items-center gap-3 px-3 text-white md:px-4"><button type="button" class="project-video-restart pointer-events-auto inline-flex h-8 w-8 shrink-0 items-center justify-center rounded text-lg text-white/90" aria-label="Restart video">&#8634;</button><span class="project-video-time shrink-0 text-xs font-bold tabular-nums">0:00 / 0:00</span><input class="project-video-progress pointer-events-auto h-1.5 min-w-0 flex-1 cursor-pointer accent-[#FF0000]" type="range" min="0" max="0" value="0" step="0.1" aria-label="Video progress"><div class="relative flex h-8 w-8 shrink-0 items-center justify-center"><input class="project-video-volume pointer-events-auto absolute bottom-full left-1/2 mb-3 h-24 w-1 -translate-x-1/2 cursor-pointer accent-[#FF0000]" type="range" min="0" max="100" value="100" step="1" aria-label="Video volume" style="writing-mode: vertical-lr; direction: rtl;"><button type="button" class="project-video-mute pointer-events-auto inline-flex h-8 w-8 items-center justify-center rounded text-base text-white/90" aria-label="Mute video">&#128266;</button></div><button type="button" class="project-video-captions pointer-events-auto rounded px-2 py-1 text-xs font-extrabold text-white/80" aria-label="Turn captions on">CC</button><button type="button" class="project-video-fullscreen pointer-events-auto inline-flex h-8 w-8 shrink-0 items-center justify-center rounded text-xl text-white/90" aria-label="Enter fullscreen">&#9974;</button></div></div>';
            var playerMount = stage.querySelector('.project-video-player');
            var controls = stage.querySelector('.project-video-controls');
            var surface = stage.querySelector('.project-video-surface');
            var progress = stage.querySelector('.project-video-progress');
            var time = stage.querySelector('.project-video-time');
            var restart = stage.querySelector('.project-video-restart');
            var mute = stage.querySelector('.project-video-mute');
            var volume = stage.querySelector('.project-video-volume');
            var captions = stage.querySelector('.project-video-captions');
            var fullscreen = stage.querySelector('.project-video-fullscreen');
            function showControls() { controls.classList.remove('pointer-events-none', 'opacity-0'); controls.classList.add('pointer-events-auto', 'opacity-100'); }
            function hideControls() { controls.classList.remove('pointer-events-auto', 'opacity-100'); controls.classList.add('pointer-events-none', 'opacity-0'); }
            function showForSixSeconds() { showControls(); window.clearTimeout(state.controlsTimer); state.controlsTimer = window.setTimeout(function () { state.controlsTimer = null; hideControls(); }, 6000); }
            stage.addEventListener('mouseenter', showControls);
            stage.addEventListener('mouseleave', function () { if (!state.controlsTimer) hideControls(); });
            stage.addEventListener('click', showForSixSeconds, true);
            surface.addEventListener('click', function () { if (!state.player || !window.YT) return; if (state.player.getPlayerState() === window.YT.PlayerState.PLAYING) { state.player.pauseVideo(); } else { state.player.playVideo(); } });
            progress.addEventListener('input', function () { if (state.player) state.player.seekTo(Number(this.value), true); });
            restart.addEventListener('click', function () { if (state.player) { state.player.seekTo(0, true); state.player.playVideo(); } });
            mute.addEventListener('click', function () { if (!state.player) return; var muted = state.player.isMuted(); if (muted) { if (Number(volume.value) === 0) volume.value = 100; state.player.setVolume(Number(volume.value)); state.player.unMute(); } else { state.player.mute(); } mute.textContent = muted ? '🔊' : '🔇'; mute.setAttribute('aria-label', muted ? 'Mute video' : 'Unmute video'); });
            volume.addEventListener('input', function () { if (!state.player) return; var value = Number(this.value); state.player.setVolume(value); if (value === 0) state.player.mute(); else state.player.unMute(); mute.textContent = value === 0 ? '🔇' : '🔊'; });
            captions.addEventListener('click', function () { if (!state.player) return; state.captionsEnabled = !state.captionsEnabled; state.player.loadModule('captions'); state.player.setOption('captions', 'track', state.captionsEnabled ? { languageCode: 'en' } : {}); captions.classList.toggle('bg-white/20', state.captionsEnabled); });
            fullscreen.addEventListener('click', function () { if (document.fullscreenElement) document.exitFullscreen?.(); else stage.requestFullscreen?.(); });
            showForSixSeconds();
            loadYouTubeApi().then(function () {
                state.player = new window.YT.Player(playerMount, {
                    host: 'https://www.youtube-nocookie.com',
                    videoId: stage.dataset.youtubeId,
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
                            state.timer = window.setInterval(function () {
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

        document.querySelectorAll('.project-video-stage').forEach(function (stage) {
            stage.querySelector('.project-video-cover').addEventListener('click', function () {
                startProjectVideo(stage);
            });
        });
    </script>
@endpush
