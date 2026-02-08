@extends('layouts.site')

@section('title', 'Contact | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <div class="grid gap-8 md:grid-cols-2">
            <div>
                <h1 class="font-display text-4xl tracking-tight">Contact</h1>
                <p class="mt-4 text-white/70">
                    Tell us what you are trying to build. If it's a fit, we'll respond with next steps.
                </p>
                <div class="mt-8 card p-6 text-sm text-white/70">
                    <div class="font-semibold text-white">Business first.</div>
                    <div class="mt-2">We focus on outcomes, timelines, and total cost of ownership.</div>
                </div>
            </div>

            <form method="POST" action="{{ route('contact.submit') }}" class="card p-6">
                @csrf
                <div class="grid gap-4">
                    <div>
                        <label class="text-xs text-white/60">Name</label>
                        <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
                        @error('name')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-xs text-white/60">Email</label>
                            <input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
                            @error('email')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs text-white/60">Phone</label>
                            <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
                            @error('phone')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-white/60">Company</label>
                        <input name="company" value="{{ old('company') }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" />
                        @error('company')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="text-xs text-white/60">Message</label>
                        <textarea name="message" rows="5" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40">{{ old('message') }}</textarea>
                        @error('message')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </section>
@endsection

