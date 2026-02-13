<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login | {{ config('app.name') }}</title>
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
        <div class="mx-auto flex min-h-screen max-w-md items-center px-4">
            <div class="card w-full p-6">
                <div class="font-display text-2xl">Admin Login</div>
                <div class="mt-2 text-sm text-white/60">Use the admin account created by the seeder.</div>

                <form method="POST" action="{{ route('admin.login') }}" class="mt-6 grid gap-3">
                    @csrf
                    <div>
                        <label class="text-xs text-white/60">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
                        @error('email')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="text-xs text-white/60">Password</label>
                        <input name="password" type="password" class="mt-1 w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" required />
                        @error('password')<div class="mt-1 text-xs text-red-300">{{ $message }}</div>@enderror
                    </div>
                    <label class="flex items-center gap-2 text-sm text-white/70">
                        <input type="checkbox" name="remember" class="rounded border-white/20 bg-black/20" />
                        Remember me
                    </label>
                    <button class="btn btn-primary" type="submit">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>

