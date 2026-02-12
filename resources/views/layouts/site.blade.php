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
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script>
                window.tailwind = window.tailwind || {};
                window.tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                                display: ['Space Grotesk', 'ui-sans-serif', 'system-ui', 'sans-serif'],
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
    <body class="tb-site min-h-screen antialiased">
        <div class="tb-background" aria-hidden="true">
            <span class="tb-orb tb-orb-a"></span>
            <span class="tb-orb tb-orb-b"></span>
            <span class="tb-orb tb-orb-c"></span>
        </div>

        <header class="tb-header">
            <div class="tb-topline">
                <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-2 text-xs font-semibold text-[#10325C]/80">
                    <div>Embedded systems studio for precision automation and reliable industrial execution.</div>
                    <a href="{{ route('contact') }}" class="hidden text-[#0B6ECD] hover:text-[#055BA9] md:inline">Start your project discussion</a>
                </div>
            </div>

            <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="{{ config('twinbot.site.domain') }}">
                    <img src="{{ asset(config('twinbot.assets.logo')) }}" alt="{{ config('twinbot.site.name') }}" class="h-10 w-auto" />
                </a>

                <nav class="hidden items-center gap-5 text-sm font-semibold text-[#375074] md:flex">
                    <a class="tb-nav-link @if(request()->routeIs('home')) tb-nav-link-active @endif" href="{{ route('home') }}">Home</a>
                    <a class="tb-nav-link @if(request()->routeIs('products.*') || request()->routeIs('shop')) tb-nav-link-active @endif" href="{{ route('products.index') }}">Products</a>
                    <a class="tb-nav-link @if(request()->routeIs('features')) tb-nav-link-active @endif" href="{{ route('features') }}">Features</a>
                    <a class="tb-nav-link @if(request()->routeIs('solutions')) tb-nav-link-active @endif" href="{{ route('solutions') }}">Solutions</a>
                    <a class="tb-nav-link @if(request()->routeIs('pricing')) tb-nav-link-active @endif" href="{{ route('pricing') }}">Pricing</a>
                    <a class="tb-nav-link @if(request()->routeIs('about')) tb-nav-link-active @endif" href="{{ route('about') }}">About</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('contact') }}" class="hidden md:inline-flex btn btn-primary">Request Proposal</a>
                    <button id="tb-menu-toggle" type="button" class="md:hidden inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#AFC3DB] bg-white text-[#1C3557]" aria-label="Open menu" aria-expanded="false">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M4 7h16M4 12h16M4 17h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="tb-mobile-nav" class="hidden border-t border-[#D7E3F0] bg-white md:hidden">
                <div class="mx-auto max-w-6xl px-4 py-4">
                    <nav class="flex flex-col gap-3 text-sm font-semibold text-[#2A476C]">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('products.index') }}">Products</a>
                        <a href="{{ route('features') }}">Features</a>
                        <a href="{{ route('solutions') }}">Solutions</a>
                        <a href="{{ route('pricing') }}">Pricing</a>
                        <a href="{{ route('projects.index') }}">Projects</a>
                        <a href="{{ route('videos.index') }}">Videos</a>
                        <a href="{{ route('about') }}">About</a>
                        <a href="{{ route('contact') }}">Contact</a>
                    </nav>
                    <a href="{{ route('contact') }}" class="mt-4 inline-flex btn btn-primary">Request Proposal</a>
                </div>
            </div>
        </header>

        <main class="relative z-10">
            @if (session('status'))
                <div class="mx-auto max-w-6xl px-4 pt-6">
                    <div class="rounded-2xl border border-[#A8D6FF] bg-[#EAF6FF] px-4 py-3 text-sm font-semibold text-[#124078]">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="relative z-10 mt-20 border-t border-[#D7E3F0] bg-white/90 backdrop-blur">
            <div class="mx-auto grid w-full max-w-6xl gap-10 px-4 py-12 md:grid-cols-4">
                <div class="md:col-span-2">
                    <img src="{{ asset(config('twinbot.assets.logo')) }}" alt="{{ config('twinbot.site.name') }}" class="h-10 w-auto" />
                    <p class="mt-4 max-w-lg text-sm leading-relaxed text-[#486080]">{{ config('twinbot.site.tagline') }} We engineer dependable, high-clarity control systems for teams that need practical automation, not complexity.</p>
                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('projects.index') }}" class="tb-mini-link">Projects</a>
                        <a href="{{ route('videos.index') }}" class="tb-mini-link">Videos</a>
                        <a href="{{ route('forum') }}" class="tb-mini-link">Forum</a>
                    </div>
                </div>

                <div>
                    <div class="tb-footer-title">Explore</div>
                    <div class="mt-3 grid gap-2 text-sm text-[#355374]">
                        <a href="{{ route('products.index') }}" class="hover:text-[#0B6ECD]">Products</a>
                        <a href="{{ route('features') }}" class="hover:text-[#0B6ECD]">Features</a>
                        <a href="{{ route('solutions') }}" class="hover:text-[#0B6ECD]">Solutions</a>
                        <a href="{{ route('pricing') }}" class="hover:text-[#0B6ECD]">Pricing</a>
                    </div>
                </div>

                <div>
                    <div class="tb-footer-title">Connect</div>
                    <div class="mt-3 grid gap-2 text-sm text-[#355374]">
                        <a href="tel:{{ config('twinbot.contact.phone_tel') }}" class="hover:text-[#0B6ECD]">{{ config('twinbot.contact.phone_display') }}</a>
                        <a href="mailto:{{ config('twinbot.contact.email_primary') }}" class="hover:text-[#0B6ECD]">{{ config('twinbot.contact.email_primary') }}</a>
                        <a href="{{ config('twinbot.contact.whatsapp_url') }}" class="hover:text-[#0B6ECD]">Whatsapp</a>
                        <span>{{ config('twinbot.contact.location') }}</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#D7E3F0] py-4">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-2 px-4 text-xs text-[#617A9A] md:flex-row md:items-center md:justify-between">
                    <div>Copyright &copy; {{ date('Y') }} {{ config('twinbot.site.domain') }}. Built by TwinBot Innov Team.</div>
                    <div>Industrial automation, embedded product engineering, and lifecycle support.</div>
                </div>
            </div>
        </footer>

        @if (env('ASSISTANT_WIDGET_ENABLED', false))
            @include('partials.assistant_widget')
        @endif
    </body>
</html>
