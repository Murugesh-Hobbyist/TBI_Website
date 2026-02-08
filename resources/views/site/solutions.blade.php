@extends('layouts.site')

@section('title', 'Solutions | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <h1 class="font-display text-4xl tracking-tight">Solutions</h1>
        <p class="mt-4 max-w-3xl text-white/70">
            This page is intended to explain your automation offerings in a business language: the problem, the approach, and the measurable outcome.
        </p>

        <div class="mt-10 grid gap-4 md:grid-cols-3">
            <div class="card p-6">
                <div class="text-xs text-white/60">01</div>
                <div class="mt-2 font-semibold">Automation Systems</div>
                <div class="mt-2 text-sm text-white/65">Design and integration for repeatable, reliable operations.</div>
            </div>
            <div class="card p-6">
                <div class="text-xs text-white/60">02</div>
                <div class="mt-2 font-semibold">Productization</div>
                <div class="mt-2 text-sm text-white/65">Convert custom work into products with clear pricing and value.</div>
            </div>
            <div class="card p-6">
                <div class="text-xs text-white/60">03</div>
                <div class="mt-2 font-semibold">Support and Scale</div>
                <div class="mt-2 text-sm text-white/65">Documentation, training, and iteration toward scalable delivery.</div>
            </div>
        </div>
    </section>
@endsection

