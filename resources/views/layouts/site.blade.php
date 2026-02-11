<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('twinbot.site.domain'))</title>
        <meta name="description" content="@yield('meta_description', config('twinbot.site.tagline'))">
        <link rel="canonical" href="@yield('canonical', url()->current())">

        <link rel="icon" href="{{ asset(config('twinbot.assets.favicon_32')) }}" sizes="32x32" />
        <link rel="icon" href="{{ asset(config('twinbot.assets.favicon_192')) }}" sizes="192x192" />
        <link rel="apple-touch-icon" href="{{ asset(config('twinbot.assets.apple_touch_icon')) }}" />
        <meta name="msapplication-TileImage" content="{{ asset(config('twinbot.assets.ms_tile')) }}" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700&family=Manrope:wght@600;700&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script>
                window.tailwind = window.tailwind || {};
                window.tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['DM Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                                display: ['Outfit', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                                button: ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'],
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
    <body class="min-h-screen bg-[#D1DAE5] text-[#222222] antialiased">

        <header class="relative z-20 bg-[#0F172A] text-white">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-5">
                <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="{{ config('twinbot.site.domain') }}">
                    <img src="{{ asset(config('twinbot.assets.logo')) }}" alt="{{ config('twinbot.site.name') }}" class="h-10 w-auto" />
                </a>

                <nav class="hidden items-center gap-6 text-sm font-semibold text-white/85 md:flex">
                    <a class="hover:text-white @if(request()->routeIs('home')) text-white @endif" href="{{ route('home') }}">Home</a>
                    <a class="hover:text-white @if(request()->routeIs('products.*') || request()->routeIs('shop')) text-white @endif" href="{{ route('products.index') }}">Products</a>
                    <a class="hover:text-white @if(request()->routeIs('features')) text-white @endif" href="{{ route('features') }}">Features</a>
                    <a class="hover:text-white @if(request()->routeIs('solutions')) text-white @endif" href="{{ route('solutions') }}">Solutions</a>
                    <a class="hover:text-white @if(request()->routeIs('pricing')) text-white @endif" href="{{ route('pricing') }}">Pricing</a>
                    <a class="hover:text-white @if(request()->routeIs('about')) text-white @endif" href="{{ route('about') }}">About</a>
                    <a class="hover:text-white @if(request()->routeIs('contact')) text-white @endif" href="{{ route('contact') }}">Request a Quote</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('contact') }}" class="hidden md:inline-flex btn btn-primary">Request a Quote</a>
                    <button id="tb-menu-toggle" type="button" class="md:hidden inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 p-2 text-white/90 hover:bg-white/10" aria-label="Open menu" aria-expanded="false">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="tb-mobile-nav" class="hidden border-t border-white/10 md:hidden">
                <div class="mx-auto max-w-6xl px-4 py-4">
                    <nav class="flex flex-col gap-3 text-sm font-semibold text-white/90">
                        <a class="hover:text-white" href="{{ route('home') }}">Home</a>
                        <a class="hover:text-white" href="{{ route('products.index') }}">Products</a>
                        <a class="hover:text-white" href="{{ route('features') }}">Features</a>
                        <a class="hover:text-white" href="{{ route('solutions') }}">Solutions</a>
                        <a class="hover:text-white" href="{{ route('pricing') }}">Pricing</a>
                        <a class="hover:text-white" href="{{ route('about') }}">About</a>
                        <a class="hover:text-white" href="{{ route('contact') }}">Request a Quote</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="relative z-10">
            @if (session('status'))
                <div class="mx-auto max-w-6xl px-4 pt-6">
                    <div class="rounded-2xl border border-[#0067FF]/20 bg-[#E7F6FF] px-4 py-3 text-sm text-[#0F172A]">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="relative z-10 mt-16 bg-[#0F172A] text-white">
            <div class="mx-auto max-w-6xl px-4 py-10">
                <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                    <div class="max-w-md">
                        <div class="font-display text-lg">{{ config('twinbot.site.name') }}</div>
                        <div class="mt-2 text-sm text-white/70">{{ config('twinbot.site.tagline') }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm text-white/80 md:grid-cols-3">
                        <a class="hover:text-white" href="{{ route('products.index') }}">Products</a>
                        <a class="hover:text-white" href="{{ route('features') }}">Features</a>
                        <a class="hover:text-white" href="{{ route('solutions') }}">Solutions</a>
                        <a class="hover:text-white" href="{{ route('pricing') }}">Pricing</a>
                        <a class="hover:text-white" href="{{ route('about') }}">About</a>
                        <a class="hover:text-white" href="{{ route('contact') }}">Contact</a>
                    </div>
                </div>
                <div class="mt-8 text-xs text-white/65">
                    Copyright &copy; {{ date('Y') }} {{ config('twinbot.site.domain') }} | Powered by TwinBot Innov Team
                </div>
            </div>
        </footer>

        @if (env('ASSISTANT_WIDGET_ENABLED', false))
            @include('partials.assistant_widget')
        @endif
    </body>
</html>
