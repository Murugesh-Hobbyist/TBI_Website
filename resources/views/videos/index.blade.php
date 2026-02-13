@extends('layouts.site')

@section('title', 'Videos | TwinBot Innovations')
@section('meta_description', 'Watch TwinBot demos, deployment snippets, and automation walkthrough videos.')

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Video Library</span>
                <h1 class="tb-heading mt-4">Automation stories you can see in action.</h1>
                <p class="tb-lead mt-5 max-w-3xl">Short visual proof of product behavior, machine outcomes, and system-level execution quality.</p>
            </div>

            @if (!($dbOk ?? true))
                <div class="mt-5 rounded-2xl border border-orange-300 bg-orange-50 px-4 py-3 text-sm font-semibold text-orange-900 tb-reveal">
                    Database is not configured yet. Configure <code>DB_*</code> in <code>.env</code> and run migrations to publish videos.
                </div>
            @endif

            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach ($videos as $video)
                    <a href="{{ route('videos.show', $video) }}" class="tb-card tb-reveal">
                        <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">Video</div>
                        <h2 class="mt-2 font-display text-xl text-[#122E53]">{{ $video->title }}</h2>
                        @if ($video->summary)
                            <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">{{ \Illuminate\Support\Str::limit(strip_tags((string) $video->summary), 140) }}</p>
                        @endif
                        <div class="mt-4 text-sm font-bold text-[#1F6FD0]">Watch now</div>
                    </a>
                @endforeach

                @if (($dbOk ?? true) && $videos->count() === 0)
                    <div class="tb-panel p-6 text-sm text-[#4F6890] md:col-span-3 tb-reveal">No published videos yet.</div>
                @endif
            </div>

            <div class="mt-8 text-sm text-[#4F6890]">
                {{ $videos->links() }}
            </div>
        </div>
    </section>
@endsection

