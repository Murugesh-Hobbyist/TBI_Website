@extends('layouts.admin')

@section('title', 'Leads')

@section('content')
    <div>
        <div class="font-display text-3xl">Leads</div>
        <div class="mt-2 text-sm text-white/60">Contact and quote requests.</div>
    </div>

    <div class="mt-6 card overflow-hidden">
        <div class="overflow-auto">
            <table class="w-full text-sm">
                <thead class="bg-white/5 text-white/70">
                    <tr>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Phone</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leads as $l)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3 text-white/70">{{ strtoupper($l->type) }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $l->name }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $l->email ?: '-' }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $l->phone ?: '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a class="btn btn-ghost" href="{{ route('admin.leads.show', $l) }}">View</a>
                                    <form method="POST" action="{{ route('admin.leads.destroy', $l) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-ghost" type="submit" onclick="return confirm('Delete lead?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 text-white/70">{{ $leads->links() }}</div>
@endsection

