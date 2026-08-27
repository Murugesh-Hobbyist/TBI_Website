@extends('layouts.site')

@section('title', $title.' | TwinBot Innovations')
@section('meta_description', $meta)

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="mx-auto max-w-4xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Policy</span>
                <h1 class="tb-heading mt-4">{{ $title }}</h1>
                <p class="mt-3 text-xs font-semibold uppercase tracking-[0.12em] text-[#607C9A]">Last updated {{ $lastUpdated }}</p>
                <p class="tb-lead mt-5">{{ $intro }}</p>
            </div>

            <div class="mt-5 grid gap-4">
                @foreach ($sections as $section)
                    <article class="tb-panel p-6 md:p-8 tb-reveal">
                        <h2 class="font-display text-xl text-[#122E53]">{{ $section['title'] }}</h2>

                        @foreach (($section['paragraphs'] ?? []) as $paragraph)
                            <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-[#4F6890]">{{ $paragraph }}</p>
                        @endforeach

                        @if (!empty($section['items']))
                            <ul class="tb-list mt-4 text-sm">
                                @foreach ($section['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </article>
                @endforeach
            </div>

            <div class="tb-cta mt-5 tb-reveal">
                <span class="tb-eyebrow">Need clarification?</span>
                <h2 class="tb-subheading mt-3">Contact TwinBot support.</h2>
                <p class="tb-lead mt-3">Share the relevant product, machine, order, or transaction reference without sending passwords, OTPs, PINs, or complete bank credentials.</p>
                <a href="{{ route('contact') }}" class="btn btn-primary mt-5">Contact / Request Quote</a>
            </div>
        </div>
    </section>
@endsection
