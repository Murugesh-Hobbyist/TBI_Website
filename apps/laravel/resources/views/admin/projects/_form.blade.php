@php
    /** @var \App\Models\Project|null $project */
@endphp

<div class="grid gap-4">
    <div>
        <label class="text-xs text-white/60">Title</label>
        <input name="title" value="{{ old('title', $project?->title) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
        @error('title')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Slug</label>
        <input name="slug" value="{{ old('slug', $project?->slug) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" placeholder="auto-generated if blank on create" />
        @error('slug')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Summary</label>
        <textarea name="summary" rows="3" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40">{{ old('summary', $project?->summary) }}</textarea>
        @error('summary')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Body</label>
        <textarea name="body" rows="10" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40">{{ old('body', $project?->body) }}</textarea>
        @error('body')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>

    <div class="flex items-center gap-3">
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', (bool) ($project?->is_published ?? false))) class="rounded border-white/20 bg-black/20" />
            Published
        </label>
        <div class="flex-1"></div>
        <div class="text-xs text-white/50">Published_at is optional.</div>
    </div>
    <div>
        <label class="text-xs text-white/60">Published At</label>
        <input name="published_at" type="datetime-local" value="{{ old('published_at', optional($project?->published_at)->format('Y-m-d\\TH:i')) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
        @error('published_at')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
</div>

