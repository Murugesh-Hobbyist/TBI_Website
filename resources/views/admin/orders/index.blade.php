@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div>
        <div class="font-display text-3xl">Orders</div>
        <div class="mt-2 text-sm text-white/60">Phase 1: order requests (payments later).</div>
    </div>

    <div class="mt-6 card overflow-hidden">
        <div class="overflow-auto">
            <table class="w-full text-sm">
                <thead class="bg-white/5 text-white/70">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Subtotal</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $o)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3 font-semibold">#{{ $o->id }}</td>
                            <td class="px-4 py-3 text-white/70">{{ strtoupper($o->status) }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $o->customer_name }}</td>
                            <td class="px-4 py-3 text-white/70">{{ $o->currency }} {{ number_format(((int) $o->subtotal_cents) / 100, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a class="btn btn-ghost" href="{{ route('admin.orders.show', $o) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 text-white/70">{{ $orders->links() }}</div>
@endsection

