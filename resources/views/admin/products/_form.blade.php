@php
    /** @var \App\Models\Product|null $product */
@endphp

<div class="grid gap-4">
    <div>
        <label class="text-xs text-white/60">Title</label>
        <input name="title" value="{{ old('title', $product?->title) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
        @error('title')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Slug</label>
        <input name="slug" value="{{ old('slug', $product?->slug) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" placeholder="auto-generated if blank on create" />
        @error('slug')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-xs text-white/60">SKU</label>
            <input name="sku" value="{{ old('sku', $product?->sku) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
            @error('sku')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-xs text-white/60">Inventory Qty</label>
            <input name="inventory_qty" type="number" value="{{ old('inventory_qty', $product?->inventory_qty ?? 0) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
            @error('inventory_qty')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-xs text-white/60">Price (cents)</label>
            <input name="price_cents" type="number" value="{{ old('price_cents', $product?->price_cents ?? 0) }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
            @error('price_cents')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
            <div class="mt-1 text-xs text-white/50">Example: 19900 = 199.00</div>
        </div>
        <div>
            <label class="text-xs text-white/60">Currency</label>
            <input name="currency" value="{{ old('currency', $product?->currency ?? 'INR') }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
            @error('currency')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
        </div>
    </div>
    <div>
        <label class="text-xs text-white/60">Summary</label>
        <textarea name="summary" rows="3" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40">{{ old('summary', $product?->summary) }}</textarea>
        @error('summary')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="text-xs text-white/60">Body</label>
        <textarea name="body" rows="10" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/40">{{ old('body', $product?->body) }}</textarea>
        @error('body')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
    </div>
    <div class="flex items-center gap-3">
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', (bool) ($product?->is_published ?? false))) class="rounded border-white/20 bg-black/20" />
            Published
        </label>
    </div>
</div>

