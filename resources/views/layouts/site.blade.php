<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light">
        <meta name="supported-color-schemes" content="light">
        <meta name="darkreader-lock">
        <meta name="theme-color" content="#eef3f9">
        <style id="tb-theme-lock">
            html { color-scheme: only light !important; forced-color-adjust: none; }
            body.tb-site { color: #112740 !important; background-color: #eef3f9 !important; }
        </style>
        <script>
            (function () {
                document.documentElement.style.colorScheme = 'only light';
                document.documentElement.setAttribute('data-tb-theme', 'light');
            })();
        </script>
        <title>@yield('title', config('twinbot.site.domain'))</title>
        <meta name="description" content="@yield('meta_description', config('twinbot.site.tagline'))">
        <link rel="canonical" href="@yield('canonical', url()->current())">

        <link rel="icon" href="{{ asset(config('twinbot.assets.favicon_32')) }}" sizes="32x32" />
        <link rel="icon" href="{{ asset(config('twinbot.assets.favicon_192')) }}" sizes="192x192" />
        <link rel="apple-touch-icon" href="{{ asset(config('twinbot.assets.apple_touch_icon')) }}" />
        <meta name="msapplication-TileImage" content="{{ asset(config('twinbot.assets.ms_tile')) }}" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            @php
                $tbCssVersion = file_exists(public_path('assets/app.css')) ? filemtime(public_path('assets/app.css')) : time();
                $tbJsVersion = file_exists(public_path('assets/app.js')) ? filemtime(public_path('assets/app.js')) : time();
            @endphp
            <script>
                window.tailwind = window.tailwind || {};
                window.tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                                display: ['Exo 2', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                            },
                        },
                    },
                };
            </script>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="{{ asset('assets/app.css') }}?v={{ $tbCssVersion }}">
            <script src="{{ asset('assets/app.js') }}?v={{ $tbJsVersion }}" defer></script>
        @endif
    </head>
    <body class="tb-site min-h-screen antialiased">
        <div class="tb-background" aria-hidden="true">
            <span class="tb-orb tb-orb-a"></span>
            <span class="tb-orb tb-orb-b"></span>
            <span class="tb-orb tb-orb-c"></span>
        </div>

        <header class="tb-header">
            <div class="tb-topline">
                <div class="tb-wrap flex w-full items-center justify-between gap-3 py-2 text-[11px] font-semibold text-[#1e456f]">
                    <div class="hidden sm:block">Embedded automation for measurable uptime, traceability, and faster operator decisions.</div>
                    <a href="{{ route('contact') }}" class="tb-mini-link">Start technical discussion</a>
                </div>
            </div>

            <div class="tb-wrap flex w-full items-center justify-between gap-3 py-3">
                <a href="{{ route('home') }}" class="tb-brand-badge" aria-label="{{ config('twinbot.site.domain') }}">
                    <img src="{{ asset(config('twinbot.assets.logo')) }}" alt="{{ config('twinbot.site.name') }}" class="h-9 w-auto" />
                </a>

                <nav class="tb-nav-rail hidden items-center text-sm font-semibold md:inline-flex">
                    <a class="tb-nav-link @if(request()->routeIs('home')) tb-nav-link-active @endif" href="{{ route('home') }}">Home</a>
                    <a class="tb-nav-link @if(request()->routeIs('products.*') || request()->routeIs('shop')) tb-nav-link-active @endif" href="{{ route('products.index') }}">Products</a>
                    <a class="tb-nav-link @if(request()->routeIs('features')) tb-nav-link-active @endif" href="{{ route('features') }}">Features</a>
                    <a class="tb-nav-link @if(request()->routeIs('solutions')) tb-nav-link-active @endif" href="{{ route('solutions') }}">Solutions</a>
                    <a class="tb-nav-link @if(request()->routeIs('pricing')) tb-nav-link-active @endif" href="{{ route('pricing') }}">Pricing</a>
                    <a class="tb-nav-link @if(request()->routeIs('projects.*')) tb-nav-link-active @endif" href="{{ route('projects.index') }}">Projects</a>
                    <a class="tb-nav-link @if(request()->routeIs('videos.*')) tb-nav-link-active @endif" href="{{ route('videos.index') }}">Videos</a>
                    <a class="tb-nav-link @if(request()->routeIs('about')) tb-nav-link-active @endif" href="{{ route('about') }}">About</a>
                </nav>

                <div class="flex items-center gap-2">
                    <a href="{{ route('contact') }}" class="btn btn-ghost hidden lg:inline-flex">Quick quote</a>
                    <a href="{{ route('contact') }}" class="btn btn-primary hidden md:inline-flex">Book Consultation</a>
                    <button id="tb-menu-toggle" type="button" class="md:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#ccd8e6] bg-white text-[#234a72]" aria-label="Open menu" aria-expanded="false">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M4 7h16M4 12h16M4 17h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="tb-mobile-nav" class="hidden border-t border-[#d7e0eb] bg-white/95 md:hidden">
                <div class="tb-wrap py-3">
                    <nav class="flex flex-col gap-1.5 text-sm font-semibold text-[#21496f]">
                        <a href="{{ route('home') }}" class="tb-mobile-link">Home</a>
                        <a href="{{ route('products.index') }}" class="tb-mobile-link">Products</a>
                        <a href="{{ route('features') }}" class="tb-mobile-link">Features</a>
                        <a href="{{ route('solutions') }}" class="tb-mobile-link">Solutions</a>
                        <a href="{{ route('pricing') }}" class="tb-mobile-link">Pricing</a>
                        <a href="{{ route('projects.index') }}" class="tb-mobile-link">Projects</a>
                        <a href="{{ route('videos.index') }}" class="tb-mobile-link">Videos</a>
                        <a href="{{ route('about') }}" class="tb-mobile-link">About</a>
                        <a href="{{ route('contact') }}" class="tb-mobile-link">Contact</a>
                    </nav>
                    <a href="{{ route('contact') }}" class="mt-3 inline-flex btn btn-primary">Book Consultation</a>
                </div>
            </div>
        </header>

        <main class="relative z-10">
            @if (session('status'))
                <div class="tb-wrap pt-4">
                    <div class="rounded-xl border border-[#bdd0e4] bg-[#eef7ff] px-4 py-2 text-sm font-semibold text-[#1d4d78]">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="relative z-10 mt-12 border-t border-[#d3ddea] bg-white/92">
            <div class="tb-wrap grid w-full gap-8 py-10 md:grid-cols-4">
                <div class="md:col-span-2">
                    <img src="{{ asset(config('twinbot.assets.logo')) }}" alt="{{ config('twinbot.site.name') }}" class="h-9 w-auto" />
                    <p class="mt-3 max-w-lg text-sm leading-relaxed text-[#4b6585]">{{ config('twinbot.site.tagline') }} We engineer practical embedded control systems focused on uptime, traceability, and easier operations.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('projects.index') }}" class="tb-mini-link">Projects</a>
                        <a href="{{ route('videos.index') }}" class="tb-mini-link">Videos</a>
                        <a href="{{ route('forum') }}" class="tb-mini-link">Forum</a>
                    </div>
                </div>

                <div>
                    <div class="tb-footer-title">Explore</div>
                    <div class="mt-2.5 grid gap-1.5 text-sm text-[#446180]">
                        <a href="{{ route('products.index') }}" class="hover:text-[#1f4f7b]">Products</a>
                        <a href="{{ route('features') }}" class="hover:text-[#1f4f7b]">Features</a>
                        <a href="{{ route('solutions') }}" class="hover:text-[#1f4f7b]">Solutions</a>
                        <a href="{{ route('pricing') }}" class="hover:text-[#1f4f7b]">Pricing</a>
                    </div>
                </div>

                <div>
                    <div class="tb-footer-title">Connect</div>
                    <div class="mt-2.5 grid gap-1.5 text-sm text-[#446180]">
                        <a href="tel:{{ config('twinbot.contact.phone_tel') }}" class="hover:text-[#1f4f7b]">{{ config('twinbot.contact.phone_display') }}</a>
                        <a href="mailto:{{ config('twinbot.contact.email_primary') }}" class="hover:text-[#1f4f7b]">{{ config('twinbot.contact.email_primary') }}</a>
                        <a href="{{ config('twinbot.contact.whatsapp_url') }}" class="hover:text-[#1f4f7b]">Whatsapp</a>
                        <span>{{ config('twinbot.contact.location') }}</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#dbe4ee] py-3">
                <div class="tb-wrap flex w-full flex-col gap-1 text-xs text-[#607c9b] md:flex-row md:items-center md:justify-between">
                    <div>Copyright &copy; {{ date('Y') }} {{ config('twinbot.site.domain') }}. Built by TwinBot Innov Team.</div>
                    <div>Embedded control, inspection automation, and lifecycle engineering support.</div>
                </div>
            </div>
        </footer>

        @if (env('ASSISTANT_WIDGET_ENABLED', false))
            @include('partials.assistant_widget')
        @endif
    </body>
</html>

