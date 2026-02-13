<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light">
        <meta name="supported-color-schemes" content="light">
        <meta name="darkreader-lock">
        <meta name="theme-color" content="#f6fbff">
        <title>@yield('title', 'Admin').' | '.config('app.name')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
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
                                display: ['Sora', 'ui-sans-serif', 'system-ui', 'sans-serif'],
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
    <body class="tb-admin min-h-screen antialiased">
        <header class="border-b border-white/10">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-xl">{{ config('app.name') }} Admin</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-ghost" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <div class="mx-auto grid max-w-6xl gap-6 px-4 py-8 md:grid-cols-4">
            <aside class="md:col-span-1">
                <nav class="card p-4 text-sm text-white/80 space-y-1">
                    <a class="block rounded-lg px-3 py-2 hover:bg-white/10" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="block rounded-lg px-3 py-2 hover:bg-white/10" href="{{ route('admin.projects.index') }}">Projects</a>
                    <a class="block rounded-lg px-3 py-2 hover:bg-white/10" href="{{ route('admin.videos.index') }}">Videos</a>
                    <a class="block rounded-lg px-3 py-2 hover:bg-white/10" href="{{ route('admin.products.index') }}">Products</a>
                    <a class="block rounded-lg px-3 py-2 hover:bg-white/10" href="{{ route('admin.orders.index') }}">Orders</a>
                    <a class="block rounded-lg px-3 py-2 hover:bg-white/10" href="{{ route('admin.leads.index') }}">Leads</a>
                    <a class="block rounded-lg px-3 py-2 hover:bg-white/10" href="{{ route('admin.kb.index') }}">Knowledge Base</a>
                </nav>

                <div class="mt-4 text-xs text-white/50">
                    Tip: publish KB articles to improve the AI assistant.
                </div>
            </aside>

            <main class="md:col-span-3">
                @if (session('status'))
                    <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>


