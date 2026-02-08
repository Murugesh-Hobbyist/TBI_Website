@extends('layouts.admin')

@section('title', 'Videos')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <div class="font-display text-3xl">Videos</div>
            <div class="mt-2 text-sm text-white/60">Automation demos and proof clips.</div>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">New</a>
    </div>

    <div class="mt-6 card overflow-hidden">
        <div class="overflow-auto">
            <table class="w-full text-sm">
                <thead class="bg-white/5 text-white/70">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Provider</th>
                        <th class="px-4 py-3 text-left">Published</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $v)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3 font-semibold">{{ $v->title }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $v->provider }} {{ $v->provider_id ? "({$v->provider_id})" : '' }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $v->is_published ? 'yes' : 'no' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a class="btn btn-ghost" href="{{ route('admin.videos.edit', $v) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.videos.destroy', $v) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-ghost" type="submit" onclick="return confirm('Delete video?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 text-white/70">{{ $videos->links() }}</div>
@endsection

