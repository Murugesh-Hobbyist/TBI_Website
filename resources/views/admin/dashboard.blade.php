@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-4 md:grid-cols-3">
        <div class="card p-6">
            <div class="text-xs text-white/60">Projects</div>
            <div class="mt-2 font-display text-3xl">{{ $counts['projects'] }}</div>
        </div>
        <div class="card p-6">
            <div class="text-xs text-white/60">Products</div>
            <div class="mt-2 font-display text-3xl">{{ $counts['products'] }}</div>
        </div>
        <div class="card p-6">
            <div class="text-xs text-white/60">Videos</div>
            <div class="mt-2 font-display text-3xl">{{ $counts['videos'] }}</div>
        </div>
        <div class="card p-6">
            <div class="text-xs text-white/60">Leads</div>
            <div class="mt-2 font-display text-3xl">{{ $counts['leads'] }}</div>
        </div>
        <div class="card p-6">
            <div class="text-xs text-white/60">Orders</div>
            <div class="mt-2 font-display text-3xl">{{ $counts['orders'] }}</div>
        </div>
        <div class="card p-6">
            <div class="text-xs text-white/60">Assistant</div>
            <div class="mt-2 text-sm text-white/70">Publish KB articles to improve answers.</div>
            <div class="mt-4">
                <a class="btn btn-ghost" href="{{ route('admin.kb.index') }}">Manage KB</a>
            </div>
        </div>
    </div>

    <div class="mt-8 grid gap-6 md:grid-cols-2">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div class="font-semibold">Latest Leads</div>
                <a href="{{ route('admin.leads.index') }}" class="text-sm text-white/60 hover:text-white">All</a>
            </div>
            <div class="mt-4 space-y-3 text-sm">
                @forelse ($latestLeads as $l)
                    <a href="{{ route('admin.leads.show', $l) }}" class="block rounded-xl border border-white/10 bg-black/20 px-4 py-3 hover:bg-white/5">
                        <div class="text-xs text-white/60">{{ strtoupper($l->type) }}</div>
                        <div class="mt-1 font-semibold">{{ $l->name }}</div>
                        <div class="mt-1 text-white/60">{{ $l->email ?: 'no email' }} · {{ $l->phone ?: 'no phone' }}</div>
                    </a>
                @empty
                    <div class="text-white/60">No leads yet.</div>
                @endforelse
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div class="font-semibold">Latest Orders</div>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-white/60 hover:text-white">All</a>
            </div>
            <div class="mt-4 space-y-3 text-sm">
                @forelse ($latestOrders as $o)
                    <a href="{{ route('admin.orders.show', $o) }}" class="block rounded-xl border border-white/10 bg-black/20 px-4 py-3 hover:bg-white/5">
                        <div class="text-xs text-white/60">#{{ $o->id }} · {{ strtoupper($o->status) }}</div>
                        <div class="mt-1 font-semibold">{{ $o->customer_name }}</div>
                        <div class="mt-1 text-white/60">{{ $o->currency }} {{ number_format(((int) $o->subtotal_cents) / 100, 2) }}</div>
                    </a>
                @empty
                    <div class="text-white/60">No orders yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

