@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <div class="font-display text-3xl">Products</div>
            <div class="mt-2 text-sm text-white/60">Catalog entries used for ecommerce and quotes.</div>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">New</a>
    </div>

    <div class="mt-6 card overflow-hidden">
        <div class="overflow-auto">
            <table class="w-full text-sm">
                <thead class="bg-white/5 text-white/70">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">SKU</th>
                        <th class="px-4 py-3 text-left">Price</th>
                        <th class="px-4 py-3 text-left">Published</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3 font-semibold">{{ $p->title }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $p->sku ?: '-' }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $p->currency }} {{ number_format(((int) $p->price_cents) / 100, 2) }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $p->is_published ? 'yes' : 'no' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a class="btn btn-ghost" href="{{ route('admin.products.edit', $p) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-ghost" type="submit" onclick="return confirm('Delete product?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 text-white/70">{{ $products->links() }}</div>
@endsection

