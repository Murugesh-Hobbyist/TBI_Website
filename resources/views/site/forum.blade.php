@extends('layouts.site')

@section('title', 'Forum - '.config('twinbot.site.domain'))

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">Forum</h1>
            <p class="mt-4 max-w-3xl text-sm text-[#364151]">
                Forum is not available yet. If you need support, use the
                <a class="font-semibold text-[#0067FF] hover:text-[#005EE9]" href="{{ route('contact') }}">contact</a>
                page.
            </p>
        </div>
    </section>
@endsection
