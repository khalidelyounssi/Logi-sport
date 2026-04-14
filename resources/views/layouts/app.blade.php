<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Logi-Sport') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-logi font-sans antialiased text-slate-100">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        @auth
            <div class="sticky top-0 z-40 border-b border-slate-800 bg-slate-950/90 backdrop-blur lg:hidden">
                <div class="flex items-center justify-between px-4 py-3">
                    <button
                        type="button"
                        @click="sidebarOpen = true"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-900 text-slate-300"
                        aria-label="Open sidebar"
                    >
                        ☰
                    </button>

                    <span class="text-sm font-semibold text-emerald-400">Logi-Sport</span>

                    <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-sm font-bold text-emerald-300 border border-slate-700">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        @endauth

        <div class="flex min-h-screen">
            @auth
                <div class="hidden w-72 shrink-0 lg:block">
                    @include('layouts.sidebar', ['mobile' => false])
                </div>

                <div
                    x-cloak
                    x-show="sidebarOpen"
                    x-transition.opacity
                    class="fixed inset-0 z-50 lg:hidden"
                    @keydown.escape.window="sidebarOpen = false"
                >
                    <div class="absolute inset-0 bg-slate-950/70" @click="sidebarOpen = false"></div>
                    <div class="relative h-full w-[88%] max-w-xs">
                        @include('layouts.sidebar', ['mobile' => true])
                    </div>
                </div>
            @endauth

            <div class="flex min-w-0 flex-1 flex-col">
                @auth
                    <header class="hidden border-b border-slate-800 bg-slate-950/70 px-8 py-5 backdrop-blur lg:block">
                        <div class="mx-auto flex w-full max-w-7xl items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-black text-slate-100">{{ $title ?? 'Dashboard' }}</h1>
                                <p class="mt-1 text-sm text-slate-400">{{ $subtitle ?? 'Welcome back to Logi-Sport.' }}</p>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-2 text-right shadow-sm">
                                    <p class="text-sm font-semibold text-slate-100">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">{{ auth()->user()->role }}</p>
                                </div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 rounded-2xl border border-slate-700 bg-slate-900 px-4 py-2 text-sm font-semibold text-slate-200 shadow-sm transition hover:bg-slate-800"
                                    >
                                        <span>🚪</span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </header>
                @endauth

                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    <div class="mx-auto w-full max-w-7xl">
                        @auth
                            <div class="mb-5 lg:hidden">
                                <h1 class="text-2xl font-black text-slate-100">{{ $title ?? 'Dashboard' }}</h1>
                                <p class="mt-1 text-sm text-slate-400">{{ $subtitle ?? 'Welcome back to Logi-Sport.' }}</p>
                            </div>
                        @endauth

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
