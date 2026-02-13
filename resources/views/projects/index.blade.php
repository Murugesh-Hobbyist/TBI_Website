@extends('layouts.site')

@section('title', 'Projects | TwinBot Innovations')
@section('meta_description', 'Browse selected TwinBot automation projects and deployment case snapshots.')

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Execution Portfolio</span>
                <h1 class="tb-heading mt-4">Proof of delivery, not just promises.</h1>
                <p class="tb-lead mt-5 max-w-3xl">These project snapshots reflect our applied engineering approach across industrial automation and embedded control challenges.</p>
            </div>

            @if (!($dbOk ?? true))
                <div class="mt-5 rounded-2xl border border-orange-300 bg-orange-50 px-4 py-3 text-sm font-semibold text-orange-900 tb-reveal">
                    Database is not configured yet. Configure <code>DB_*</code> in <code>.env</code> and run migrations to publish projects.
                </div>
            @endif

            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach ($projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="tb-card tb-reveal">
                        <div class="text-xs font-extrabold uppercase tracking-[0.12em] text-[#607C9A]">Project</div>
                        <h2 class="mt-2 font-display text-xl text-[#122E53]">{{ $project->title }}</h2>
                        @if ($project->summary)
                            <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">{{ \Illuminate\Support\Str::limit(strip_tags((string) $project->summary), 140) }}</p>
                        @endif
                        <div class="mt-4 text-sm font-bold text-[#1F6FD0]">Read case details</div>
                    </a>
                @endforeach

                @if (($dbOk ?? true) && $projects->count() === 0)
                    <div class="tb-panel p-6 text-sm text-[#4F6890] md:col-span-3 tb-reveal">No published projects yet.</div>
                @endif
            </div>

            <div class="mt-8 text-sm text-[#4F6890]">
                {{ $projects->links() }}
            </div>
        </div>
    </section>
@endsection

