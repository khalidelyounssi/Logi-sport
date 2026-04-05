<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Logi-Sport') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900">
    @php
        $dashboardRoute = 'login';

        if (auth()->check()) {
            $dashboardRoute = match (auth()->user()->role) {
                'admin' => 'admin.dashboard',
                'organizer' => 'organizer.dashboard',
                'referee' => 'referee.dashboard',
                default => 'player.dashboard',
            };
        }
    @endphp

    <div class="min-h-screen bg-gradient-to-b from-blue-50 via-slate-50 to-white">
        <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">⚽</span>
                    <span class="text-lg font-black text-blue-700">Logi-Sport</span>
                </a>

                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="mx-auto grid w-full max-w-7xl grid-cols-1 gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-20">
            <section class="space-y-6">
                <p class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-blue-700">
                    <span>Modern Tournament SaaS</span>
                </p>
                <h1 class="text-4xl font-black leading-tight text-slate-900 sm:text-5xl">
                    Organize Amateur Sports Tournaments End-to-End
                </h1>
                <p class="max-w-xl text-base text-slate-600">
                    Logi-Sport helps organizers create tournaments, register participants, generate match schedules,
                    collect referee scores, and publish standings in real time.
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                            🚀 Discover the Platform
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Sign In
                        </a>
                    @else
                        <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                            Go to Dashboard
                        </a>
                    @endguest
                </div>
            </section>

            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">01</p>
                    <h3 class="mt-2 text-lg font-black text-slate-900">Tournament Management</h3>
                    <p class="mt-2 text-sm text-slate-600">Create and manage tournaments with clean workflows.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">02</p>
                    <h3 class="mt-2 text-lg font-black text-slate-900">Automatic Scheduling</h3>
                    <p class="mt-2 text-sm text-slate-600">Generate round-robin matches instantly.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">03</p>
                    <h3 class="mt-2 text-lg font-black text-slate-900">Live Score Entry</h3>
                    <p class="mt-2 text-sm text-slate-600">Referees can update results in real time.</p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">04</p>
                    <h3 class="mt-2 text-lg font-black text-slate-900">Standings & Stats</h3>
                    <p class="mt-2 text-sm text-slate-600">Track rankings and team performance instantly.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
