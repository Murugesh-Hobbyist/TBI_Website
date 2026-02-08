@php
    /** @var \App\Models\KbArticle|null $article */
@endphp

<div class="grid gap-4">
    <div>
        <label class="text-xs text-white/60">Title</label>
        <input name="title" value="{{ old('title', $article?->title) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
        @error('title')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Slug</label>
        <input name="slug" value="{{ old('slug', $article?->slug) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" placeholder="auto-generated if blank on create" />
        @error('slug')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Tags (comma separated)</label>
        <input name="tags" value="{{ old('tags', $article?->tags) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
        @error('tags')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Body</label>
        <textarea name="body" rows="14" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required>{{ old('body', $article?->body) }}</textarea>
        @error('body')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
        <div class="mt-1 text-xs text-white/50">Write fact-based content. The assistant will quote this.</div>
    </div>
    <div class="flex items-center gap-3">
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', (bool) ($article?->is_published ?? false))) class="rounded border-white/20 bg-black/20" />
            Published
        </label>
    </div>
</div>

