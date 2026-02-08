@extends('layouts.site')

@section('title', 'Forum | Finboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <h1 class="font-display text-4xl tracking-tight">Forum</h1>
        <p class="mt-4 max-w-3xl text-white/70">
            Phase 1: this route is a placeholder so your navigation is stable. In Phase 2, we can integrate a full forum (Laravel-based or a dedicated forum app) and unify branding.
        </p>
        <div class="mt-8 card p-6 text-sm text-white/70">
            Recommended approach: deploy a dedicated forum (for example, Flarum) at `/forum` and keep the main site on Laravel.
        </div>
    </section>
@endsection

