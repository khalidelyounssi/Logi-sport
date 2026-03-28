<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Logi-Sport') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f5f7ff] text-slate-900">
    <div class="min-h-screen flex">
        @auth
            @include('layouts.sidebar')
        @endauth

        <div class="flex-1 min-h-screen">
            @auth
                <header class="bg-white/80 backdrop-blur border-b border-slate-200 px-6 lg:px-10 py-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $title ?? 'Dashboard' }}</h2>
                        <p class="text-slate-500 text-sm">{{ $subtitle ?? 'Welcome back to Logi-Sport.' }}</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="hidden md:flex items-center bg-slate-100 rounded-2xl px-4 py-3 w-80">
                            <input
                                type="text"
                                placeholder="Search tournaments, teams, or players..."
                                class="bg-transparent outline-none w-full text-sm text-slate-600 placeholder:text-slate-400"
                            >
                        </div>

                        <div class="w-11 h-11 rounded-2xl bg-white border border-slate-200 flex items-center justify-center">
                            🔔
                        </div>

                        <div class="flex items-center gap-3 bg-white rounded-2xl px-3 py-2 border border-slate-200">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                                <p class="text-xs uppercase tracking-wider text-slate-400">{{ auth()->user()->role }}</p>
                            </div>
                            <div class="w-11 h-11 rounded-2xl bg-blue-100 flex items-center justify-center">
                                👤
                            </div>
                        </div>
                    </div>
                </header>
            @endauth

            <main class="p-6 lg:p-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>