@extends('layouts.admin')

@section('title', 'Lead #'.$lead->id)

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <div class="font-display text-3xl">Lead #{{ $lead->id }}</div>
            <div class="mt-2 text-sm text-white/60">{{ strtoupper($lead->type) }} · {{ $lead->created_at }}</div>
        </div>
        <a href="{{ route('admin.leads.index') }}" class="btn btn-ghost">Back</a>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2">
        <div class="card p-6">
            <div class="text-xs text-white/60">Name</div>
            <div class="mt-2 font-semibold">{{ $lead->name }}</div>
            <div class="mt-4 text-xs text-white/60">Email</div>
            <div class="mt-2 text-sm text-white/80">{{ $lead->email ?: '-' }}</div>
            <div class="mt-4 text-xs text-white/60">Phone</div>
            <div class="mt-2 text-sm text-white/80">{{ $lead->phone ?: '-' }}</div>
            <div class="mt-4 text-xs text-white/60">Company</div>
            <div class="mt-2 text-sm text-white/80">{{ $lead->company ?: '-' }}</div>
        </div>
        <div class="card p-6">
            <div class="text-xs text-white/60">Message</div>
            <div class="mt-2 whitespace-pre-wrap text-sm text-white/80">{{ $lead->message ?: '-' }}</div>
            <div class="mt-6 text-xs text-white/60">Meta</div>
            <pre class="mt-2 overflow-auto rounded-xl border border-white/10 bg-black/20 p-3 text-xs text-white/70">{{ json_encode($lead->meta, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
@endsection

