@extends('layouts.site')

@section('title', 'Request Quote | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <div class="grid gap-8 md:grid-cols-2">
            <div>
                <h1 class="font-display text-4xl tracking-tight">Request Quote</h1>
                <p class="mt-4 text-white/70">
                    Give us enough context to estimate effort, constraints, and timeline. We will respond with a clear next step.
                </p>
                <div class="mt-8 grid gap-4">
                    <div class="card p-6">
                        <div class="text-xs text-white/60">What you get</div>
                        <div class="mt-2 font-semibold">A scoped proposal</div>
                        <div class="mt-2 text-sm text-white/65">Deliverables, milestones, and commercial terms.</div>
                    </div>
                    <div class="card p-6">
                        <div class="text-xs text-white/60">Typical response time</div>
                        <div class="mt-2 font-semibold">24 to 48 hours</div>
                        <div class="mt-2 text-sm text-white/65">For complete requests. Faster for existing customers.</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('quote.submit') }}" class="card p-6">
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
                        <label class="text-xs text-white/60">Requirements</label>
                        <textarea name="message" rows="6" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" placeholder="Industry, problem, expected output, constraints...">{{ old('message') }}</textarea>
                        @error('message')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </section>
@endsection

