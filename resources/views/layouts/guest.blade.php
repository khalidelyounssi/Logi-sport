<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Logi-Sport') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900">
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        <section class="hidden items-center justify-center border-r border-slate-200 bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 px-10 py-16 text-white lg:flex">
            <div class="max-w-xl space-y-6">
                <p class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em]">
                    <span>⚽</span>
                    <span>Logi-Sport</span>
                </p>

                <h1 class="text-4xl font-black leading-tight">
                    Organize tournaments faster and smarter.
                </h1>

                <p class="text-base text-blue-50/90">
                    Create tournaments, generate matches automatically, assign referees, and track standings in real time.
                </p>
            </div>
        </section>

        <section class="flex min-h-screen items-center justify-center px-4 py-10 sm:px-8">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </section>
    </div>
</body>
</html>
