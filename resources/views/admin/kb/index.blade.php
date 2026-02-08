@extends('layouts.admin')

@section('title', 'Knowledge Base')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <div class="font-display text-3xl">Knowledge Base</div>
            <div class="mt-2 text-sm text-white/60">This content powers the AI assistant.</div>
        </div>
        <a href="{{ route('admin.kb.create') }}" class="btn btn-primary">New</a>
    </div>

    <div class="mt-6 card overflow-hidden">
        <div class="overflow-auto">
            <table class="w-full text-sm">
                <thead class="bg-white/5 text-white/70">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Tags</th>
                        <th class="px-4 py-3 text-left">Published</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $a)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3 font-semibold">{{ $a->title }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $a->tags ?: '-' }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $a->is_published ? 'yes' : 'no' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a class="btn btn-ghost" href="{{ route('admin.kb.edit', $a) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.kb.destroy', $a) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-ghost" type="submit" onclick="return confirm('Delete article?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 text-white/70">{{ $articles->links() }}</div>
@endsection

