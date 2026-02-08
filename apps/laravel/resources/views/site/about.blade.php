@extends('layouts.site')

@section('title', 'About | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <h1 class="font-display text-4xl tracking-tight">About</h1>
        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <div class="card p-6">
                <h2 class="font-display text-2xl">Who We Are</h2>
                <p class="mt-3 text-sm text-white/70">
                    Replace this with your story: mission, expertise, and the kind of projects you deliver.
                </p>
            </div>
            <div class="card p-6">
                <h2 class="font-display text-2xl">What We Believe</h2>
                <p class="mt-3 text-sm text-white/70">
                    Business outcomes matter. Automation should be understandable, auditable, and built to last.
                </p>
            </div>
        </div>
    </section>
@endsection

