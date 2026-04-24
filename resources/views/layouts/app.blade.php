<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Logi-Sport') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-logi font-sans antialiased text-slate-100">
    @php
        $user = auth()->user();
        $role = $user?->role;

        $currentTournament = request()->route('tournament');

        if (! $currentTournament instanceof \App\Models\Tournament) {
            $currentTournament = null;
        }

        if ($role === 'organizer' && ! $currentTournament && $user) {
            $currentTournament = $user->tournaments()->latest('id')->first();
        }

        $notificationsEnabled = Route::has('notifications.index');
        $unreadNotificationsCount = $notificationsEnabled && $user
            ? $user->notifications()->where('is_read', false)->count()
            : 0;

        $playerTournamentsEnabled = Route::has('player.tournaments');
        $playerMatchesEnabled = Route::has('player.matches');

        $navItems = [];

        if ($role === 'organizer') {
            $navItems = [
                ['label' => 'Dashboard', 'href' => route('organizer.dashboard'), 'active' => request()->routeIs('organizer.dashboard')],
                ['label' => 'Notifications', 'href' => route('notifications.index'), 'active' => request()->routeIs('notifications.*'), 'badge' => $unreadNotificationsCount],
                ['label' => 'Tournaments', 'href' => route('tournaments.index'), 'active' => request()->routeIs('tournaments.index', 'tournaments.create', 'tournaments.show', 'tournaments.edit')],
                ['label' => 'Participants', 'href' => $currentTournament ? route('tournaments.participants.index', $currentTournament) : route('tournaments.index'), 'active' => request()->routeIs('tournaments.participants.*')],
                ['label' => 'Matches', 'href' => $currentTournament ? route('tournaments.matches.index', $currentTournament) : route('tournaments.index'), 'active' => request()->routeIs('tournaments.matches.*')],
                ['label' => 'Standings', 'href' => $currentTournament ? route('tournaments.standings.index', $currentTournament) : route('tournaments.index'), 'active' => request()->routeIs('tournaments.standings.*')],
            ];
        } elseif ($role === 'referee') {
            $navItems = [
                ['label' => 'Dashboard', 'href' => route('referee.dashboard'), 'active' => request()->routeIs('referee.dashboard')],
                ['label' => 'Notifications', 'href' => route('notifications.index'), 'active' => request()->routeIs('notifications.*'), 'badge' => $unreadNotificationsCount],
                ['label' => 'My Matches', 'href' => route('referee.matches.index'), 'active' => request()->routeIs('referee.matches.*')],
            ];
        } elseif ($role === 'player') {
            $navItems = [
                ['label' => 'Dashboard', 'href' => route('player.dashboard'), 'active' => request()->routeIs('player.dashboard')],
                ['label' => 'Notifications', 'href' => route('notifications.index'), 'active' => request()->routeIs('notifications.*'), 'badge' => $unreadNotificationsCount],
                ['label' => 'My Tournaments', 'href' => $playerTournamentsEnabled ? route('player.tournaments') : '#', 'active' => $playerTournamentsEnabled && request()->routeIs('player.tournaments'), 'disabled' => ! $playerTournamentsEnabled],
                ['label' => 'My Matches', 'href' => $playerMatchesEnabled ? route('player.matches') : '#', 'active' => $playerMatchesEnabled && request()->routeIs('player.matches'), 'disabled' => ! $playerMatchesEnabled],
                ['label' => 'My Profile', 'href' => route('player.profile'), 'active' => request()->routeIs('player.profile')],
            ];
        } elseif ($role === 'admin') {
            $navItems = [
                ['label' => 'Dashboard', 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
                ['label' => 'Notifications', 'href' => route('notifications.index'), 'active' => request()->routeIs('notifications.*'), 'badge' => $unreadNotificationsCount],
                ['label' => 'Users', 'href' => route('admin.users'), 'active' => request()->routeIs('admin.users')],
                ['label' => 'Sports', 'href' => route('sports.index'), 'active' => request()->routeIs('sports.*')],
            ];
        }
    @endphp

    <div x-data="{ mobileMenuOpen: false }" class="ls-shell text-slate-100">
        @auth
            <div class="relative z-10 flex min-h-screen flex-col">
                <header class="ls-topbar sticky top-0 z-50">
                    <div class="mx-auto flex w-full max-w-[1500px] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-700/80 bg-slate-950/70 text-slate-200 lg:hidden"
                                @click="mobileMenuOpen = ! mobileMenuOpen"
                                aria-label="Open navigation menu"
                            >
                                <span class="flex flex-col gap-1">
                                    <span class="block h-0.5 w-5 rounded-full bg-current"></span>
                                    <span class="block h-0.5 w-5 rounded-full bg-current"></span>
                                    <span class="block h-0.5 w-5 rounded-full bg-current"></span>
                                </span>
                            </button>

                            <a href="{{ url('/') }}" class="flex items-center gap-3">
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-[18px] border border-emerald-400/25 bg-emerald-400/10 text-emerald-300">
                                    <x-logo-mark class="h-7 w-7" />
                                </span>
                                <span>
                                    <span class="block text-[11px] uppercase tracking-[0.28em] text-slate-500">Logi-Sport</span>
                                    <span class="block text-lg font-black text-white">Command Center</span>
                                </span>
                            </a>
                        </div>

                        <nav class="hidden items-center gap-2 lg:flex">
                            @foreach($navItems as $item)
                                <a
                                    href="{{ $item['href'] }}"
                                    class="ls-nav-link {{ !empty($item['disabled']) ? 'pointer-events-none cursor-not-allowed opacity-40' : ($item['active'] ? 'ls-nav-link-active' : 'ls-nav-link-inactive') }}"
                                >
                                    <span>{{ $item['label'] }}</span>
                                    @if(!empty($item['badge']) && $item['badge'] > 0)
                                        <span class="rounded-full bg-white/5 px-2.5 py-1 text-[10px] font-black text-emerald-300">{{ $item['badge'] }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </nav>

                        <div class="hidden items-center gap-3 sm:flex">
                            <div class="ls-panel-soft flex items-center gap-3 px-4 py-2.5">
                                <div class="min-w-0 text-right">
                                    <p class="truncate text-sm font-semibold text-white">{{ $user->name }}</p>
                                    <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">{{ $role }}</p>
                                </div>
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-700 bg-slate-950/80 text-sm font-bold text-emerald-300">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-2xl border border-slate-700/80 bg-slate-950/80 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:border-emerald-400/30 hover:bg-slate-900"
                                >
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <div x-cloak x-show="mobileMenuOpen" x-transition class="border-t border-slate-800/70 bg-slate-950/95 lg:hidden">
                        <div class="mx-auto flex w-full max-w-[1500px] flex-col gap-2 px-4 py-4 sm:px-6">
                            @foreach($navItems as $item)
                                <a
                                    href="{{ $item['href'] }}"
                                    class="ls-nav-link {{ !empty($item['disabled']) ? 'pointer-events-none cursor-not-allowed opacity-40' : ($item['active'] ? 'ls-nav-link-active' : 'ls-nav-link-inactive') }}"
                                    @click="mobileMenuOpen = false"
                                >
                                    <span>{{ $item['label'] }}</span>
                                    @if(!empty($item['badge']) && $item['badge'] > 0)
                                        <span class="rounded-full bg-white/5 px-2.5 py-1 text-[10px] font-black text-emerald-300">{{ $item['badge'] }}</span>
                                    @endif
                                </a>
                            @endforeach

                            <form method="POST" action="{{ route('logout') }}" class="pt-2 sm:hidden">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-900"
                                >
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <main class="relative z-10 w-full flex-1 p-4 sm:p-6 lg:p-8">
                    <div class="mx-auto w-full max-w-[1500px]">
                        @auth
                            <div class="mb-6 ls-hero">
                                <div class="ls-hero-banner">
                                    <span class="ls-kicker">Active Workspace</span>
                                    <h1 class="mt-5 max-w-2xl text-3xl font-black leading-tight text-white lg:text-5xl">{{ $title ?? 'Dashboard' }}</h1>
                                    <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300 lg:text-base">{{ $subtitle ?? 'Welcome back to Logi-Sport.' }}</p>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                                    <div class="ls-stat-card">
                                        <p class="ls-stat-label">Navigation Modules</p>
                                        <p class="ls-stat-value">{{ count($navItems) }}</p>
                                        <p class="ls-stat-trend">Ready for action</p>
                                    </div>

                                    <div class="ls-stat-card">
                                        <p class="ls-stat-label">Unread Alerts</p>
                                        <p class="ls-stat-value">{{ $unreadNotificationsCount }}</p>
                                        <p class="mt-3 text-sm text-slate-400">Everything important stays visible from your control center.</p>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        {{ $slot }}
                    </div>
                </main>
            </div>
        @endauth
    </div>
</body>
</html>
