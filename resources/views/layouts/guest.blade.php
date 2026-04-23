<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Logi-Sport') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-logi font-sans antialiased text-slate-100">
    @php
        $guestNavItems = [
            ['label' => 'Home', 'href' => url('/')],
        ];

        if (Route::has('login')) {
            $guestNavItems[] = ['label' => 'Login', 'href' => route('login')];
        }

        if (Route::has('register')) {
            $guestNavItems[] = ['label' => 'Register', 'href' => route('register')];
        }

        if (auth()->check()) {
            $guestNavItems[] = ['label' => 'Dashboard', 'href' => match (auth()->user()->role) {
                'admin' => route('admin.dashboard'),
                'organizer' => route('organizer.dashboard'),
                'referee' => route('referee.dashboard'),
                'player' => route('player.dashboard'),
                default => url('/'),
            }];
        }
    @endphp

    <div class="ls-shell flex min-h-screen flex-col">
        <header class="ls-topbar sticky top-0 z-50">
            <div class="mx-auto flex w-full max-w-[1500px] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-[18px] border border-emerald-400/30 bg-emerald-400/10 font-black text-emerald-300">LS</span>
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.28em] text-slate-500">Logi-Sport</p>
                        <p class="text-lg font-black text-white">Guest Access</p>
                    </div>
                </a>

                <nav class="flex flex-wrap items-center gap-2">
                    @foreach($guestNavItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            class="rounded-2xl px-3 py-2 text-xs font-semibold transition {{ request()->url() === $item['href'] ? 'bg-emerald-400 text-slate-950' : 'bg-slate-950/70 text-slate-300 hover:bg-slate-900' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </header>

        <div class="lg:grid lg:min-h-[calc(100vh-76px)] lg:grid-cols-[1.12fr_0.88fr]">
        <section class="relative hidden min-h-full overflow-hidden border-r border-slate-800/70 px-10 py-16 text-white lg:flex lg:items-center">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(53,224,161,0.18),_transparent_28%),linear-gradient(135deg,_rgba(5,14,27,0.95),_rgba(7,18,36,0.75))]"></div>
            <div class="absolute inset-y-16 right-10 w-[320px] rounded-[32px] border border-white/10 bg-white/5 blur-3xl"></div>

            <div class="relative z-10 mx-auto w-full max-w-2xl space-y-8">
                <p class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-200">
                    <span>Logi-Sport Elite Suite</span>
                </p>

                <div>
                    <h1 class="max-w-xl text-5xl font-black leading-[1.05]">
                        Control every tournament from one cinematic workspace.
                    </h1>

                    <p class="mt-6 max-w-xl text-base leading-8 text-slate-300">
                        Build brackets, monitor scores, manage participants, and keep every role aligned with a polished command-center experience.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="ls-panel-soft p-4">
                        <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Live Control</p>
                        <p class="mt-3 text-2xl font-black text-white">24/7</p>
                    </div>
                    <div class="ls-panel-soft p-4">
                        <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Fast Setup</p>
                        <p class="mt-3 text-2xl font-black text-white">3 Steps</p>
                    </div>
                    <div class="ls-panel-soft p-4">
                        <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Unified Roles</p>
                        <p class="mt-3 text-2xl font-black text-white">4 Views</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative flex min-h-screen items-center justify-center px-4 py-10 sm:px-8">
            <div class="relative z-10 w-full max-w-md">
                {{ $slot }}
            </div>
        </section>
        </div>
    </div>
</body>
</html>
