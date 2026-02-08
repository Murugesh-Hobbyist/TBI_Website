@php
    /** @var \App\Models\Video|null $video */
@endphp

<div class="grid gap-4">
    <div>
        <label class="text-xs text-white/60">Title</label>
        <input name="title" value="{{ old('title', $video?->title) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
        @error('title')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Slug</label>
        <input name="slug" value="{{ old('slug', $video?->slug) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" placeholder="auto-generated if blank on create" />
        @error('slug')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Summary</label>
        <textarea name="summary" rows="3" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40">{{ old('summary', $video?->summary) }}</textarea>
        @error('summary')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-xs text-white/60">Provider</label>
            <select name="provider" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40">
                @foreach (['youtube','vimeo','file'] as $p)
                    <option value="{{ $p }}" @selected(old('provider', $video?->provider ?? 'youtube') === $p)>{{ $p }}</option>
                @endforeach
            </select>
            @error('provider')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-xs text-white/60">Provider ID</label>
            <input name="provider_id" value="{{ old('provider_id', $video?->provider_id) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
            @error('provider_id')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
        </div>
    </div>
    <div>
        <label class="text-xs text-white/60">Thumbnail URL (optional)</label>
        <input name="thumbnail_url" value="{{ old('thumbnail_url', $video?->thumbnail_url) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
        @error('thumbnail_url')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div class="flex items-center gap-3">
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', (bool) ($video?->is_published ?? false))) class="rounded border-white/20 bg-black/20" />
            Published
        </label>
    </div>
    <div>
        <label class="text-xs text-white/60">Published At</label>
        <input name="published_at" type="datetime-local" value="{{ old('published_at', optional($video?->published_at)->format('Y-m-d\\TH:i')) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
        @error('published_at')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
</div>

