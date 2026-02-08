@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <div class="font-display text-3xl">Projects</div>
            <div class="mt-2 text-sm text-white/60">Portfolio entries for credibility and proof.</div>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">New</a>
    </div>

    <div class="mt-6 card overflow-hidden">
        <div class="overflow-auto">
            <table class="w-full text-sm">
                <thead class="bg-white/5 text-white/70">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Slug</th>
                        <th class="px-4 py-3 text-left">Published</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $p)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3 font-semibold">{{ $p->title }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $p->slug }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $p->is_published ? 'yes' : 'no' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a class="btn btn-ghost" href="{{ route('admin.projects.edit', $p) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $p) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-ghost" type="submit" onclick="return confirm('Delete project?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 text-white/70">{{ $projects->links() }}</div>
@endsection

