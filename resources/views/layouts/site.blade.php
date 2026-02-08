<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700&family=fraunces:600,700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script>
                window.tailwind = window.tailwind || {};
                window.tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                                display: ['Fraunces', 'ui-serif', 'Georgia', 'serif'],
                            },
                        },
                    },
                };
            </script>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
            <script src="{{ asset('assets/app.js') }}" defer></script>
        @endif
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
        <div class="pointer-events-none fixed inset-0 opacity-70">
            <div class="absolute -top-24 left-1/2 h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-emerald-500/20 blur-3xl"></div>
            <div class="absolute bottom-[-180px] right-[-180px] h-[540px] w-[540px] rounded-full bg-sky-500/15 blur-3xl"></div>
            <div class="absolute top-1/3 left-[-200px] h-[420px] w-[420px] rounded-full bg-orange-500/10 blur-3xl"></div>
        </div>

        <header class="relative z-10 border-b border-white/10">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-5">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-emerald-400 to-sky-400"></div>
                    <div class="leading-tight">
                        <div class="font-display text-lg tracking-tight">{{ config('app.name', 'Finboard') }}</div>
                        <div class="text-xs text-white/60">Automation. Precision. Scale.</div>
                    </div>
                </a>

                <nav class="hidden items-center gap-6 text-sm text-white/80 md:flex">
                    <a class="hover:text-white" href="{{ route('solutions') }}">Solutions</a>
                    <a class="hover:text-white" href="{{ route('projects.index') }}">Projects</a>
                    <a class="hover:text-white" href="{{ route('products.index') }}">Products</a>
                    <a class="hover:text-white" href="{{ route('videos.index') }}">Videos</a>
                    <a class="hover:text-white" href="{{ route('about') }}">About</a>
                    <a class="hover:text-white" href="{{ route('contact') }}">Contact</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('cart.show') }}" class="hidden rounded-xl border border-white/15 bg-white/5 px-4 py-2 text-sm text-white/90 hover:bg-white/10 md:inline-flex">Cart</a>
                    <a href="{{ route('quote') }}" class="inline-flex rounded-xl bg-white px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-white/90">Request Quote</a>
                </div>
            </div>
        </header>

        <main class="relative z-10">
            @if (session('status'))
                <div class="mx-auto max-w-6xl px-4 pt-6">
                    <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="relative z-10 mt-20 border-t border-white/10">
            <div class="mx-auto max-w-6xl px-4 py-10">
                <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                    <div>
                        <div class="font-display text-lg">{{ config('app.name', 'Finboard') }}</div>
                        <div class="mt-2 max-w-md text-sm text-white/60">
                            A business-grade platform for showcasing automation, products, and proof of work. Built for credibility, clarity, and conversion.
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm text-white/70 md:grid-cols-3">
                        <a class="hover:text-white" href="{{ route('projects.index') }}">Projects</a>
                        <a class="hover:text-white" href="{{ route('products.index') }}">Products</a>
                        <a class="hover:text-white" href="{{ route('videos.index') }}">Videos</a>
                        <a class="hover:text-white" href="{{ route('forum') }}">Forum</a>
                        <a class="hover:text-white" href="{{ route('quote') }}">Request Quote</a>
                        <a class="hover:text-white" href="{{ route('contact') }}">Contact</a>
                    </div>
                </div>
                <div class="mt-8 text-xs text-white/45">
                    (c) {{ date('Y') }} {{ config('app.name', 'Finboard') }}. All rights reserved.
                </div>
            </div>
        </footer>

        @include('partials.assistant_widget')
    </body>
</html>
