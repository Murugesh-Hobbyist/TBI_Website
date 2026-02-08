@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <div class="font-display text-3xl">Edit Project</div>
            <div class="mt-2 text-sm text-white/60">Public URL: <a class="underline hover:text-white" href="{{ route('projects.show', $project) }}" target="_blank" rel="noreferrer">{{ route('projects.show', $project) }}</a></div>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="mt-6 card p-6">
        @csrf
        @method('PUT')
        @include('admin.projects._form', ['project' => $project])
        <div class="mt-6 flex gap-3">
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-ghost" type="submit" form="delete-project" onclick="return confirm('Delete project?')">Delete</button>
        </div>
    </form>

    <form id="delete-project" method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <div class="mt-6 card p-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="font-semibold">Project Media</div>
                <div class="mt-1 text-sm text-white/60">Upload images or attach external links.</div>
            </div>
        </div>

        <form class="mt-4 grid gap-3 md:grid-cols-4" method="POST" action="{{ route('admin.projects.media.store', $project) }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label class="text-xs text-white/60">Type</label>
                <select name="type" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40">
                    @foreach (['image','video','file'] as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs text-white/60">Title</label>
                <input name="title" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
            </div>
            <div>
                <label class="text-xs text-white/60">External URL (optional)</label>
                <input name="external_url" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
            </div>
            <div>
                <label class="text-xs text-white/60">File (optional)</label>
                <input name="file" type="file" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
            </div>
            <div class="md:col-span-4">
                <button class="btn btn-primary" type="submit">Add Media</button>
            </div>
        </form>

        <div class="mt-6 grid gap-3 md:grid-cols-2">
            @forelse ($project->media as $m)
                <div class="rounded-xl border border-white/10 bg-black/20 p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-xs text-white/60">{{ strtoupper($m->type) }}</div>
                            <div class="mt-1 font-semibold">{{ $m->title ?: '(untitled)' }}</div>
                            @if ($m->external_url)
                                <div class="mt-2 text-sm text-white/70 break-words">{{ $m->external_url }}</div>
                            @endif
                            @if ($m->path)
                                <div class="mt-2 text-sm text-white/70 break-words">{{ $m->path }}</div>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('admin.projects.media.destroy', $m) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-ghost" type="submit" onclick="return confirm('Remove media?')">Remove</button>
                        </form>
                    </div>
                    @if ($m->type === 'image' && $m->path)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($m->path) }}" alt="" class="mt-3 h-44 w-full rounded-lg object-cover" />
                    @endif
                </div>
            @empty
                <div class="text-sm text-white/60 md:col-span-2">No media yet.</div>
            @endforelse
        </div>
    </div>
@endsection
