@extends('layouts.admin')

@section('title', 'Order #'.$order->id)

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <div class="font-display text-3xl">Order #{{ $order->id }}</div>
            <div class="mt-2 text-sm text-white/60">{{ strtoupper($order->status) }} - {{ $order->created_at }}</div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">Back</a>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2">
        <div class="card p-6">
            <div class="text-xs text-white/60">Customer</div>
            <div class="mt-2 font-semibold">{{ $order->customer_name }}</div>
            <div class="mt-4 text-xs text-white/60">Email</div>
            <div class="mt-2 text-sm text-white/80">{{ $order->customer_email ?: '-' }}</div>
            <div class="mt-4 text-xs text-white/60">Phone</div>
            <div class="mt-2 text-sm text-white/80">{{ $order->customer_phone ?: '-' }}</div>
            <div class="mt-4 text-xs text-white/60">Notes</div>
            <div class="mt-2 whitespace-pre-wrap text-sm text-white/80">{{ $order->notes ?: '-' }}</div>
        </div>
        <div class="card p-6">
            <div class="text-xs text-white/60">Items</div>
            <div class="mt-4 space-y-3">
                @foreach ($order->items as $it)
                    <div class="rounded-xl border border-white/10 bg-black/20 px-4 py-3">
                        <div class="font-semibold">{{ $it->title }}</div>
                        <div class="mt-1 text-sm text-white/60">
                            Qty: {{ $it->qty }}
                            @if ($it->sku) - SKU: {{ $it->sku }} @endif
                        </div>
                        <div class="mt-2 text-sm text-white/80">
                            {{ $order->currency }} {{ number_format(((int) $it->line_total_cents) / 100, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 border-t border-white/10 pt-4 text-right">
                <div class="text-sm text-white/60">Subtotal</div>
                <div class="mt-1 font-display text-3xl">{{ $order->currency }} {{ number_format(((int) $order->subtotal_cents) / 100, 2) }}</div>
            </div>
        </div>
    </div>
@endsection
