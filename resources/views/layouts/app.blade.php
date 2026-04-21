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
                ['label' => 'Tournaments', 'href' => route('tournaments.index'), 'active' => request()->routeIs('tournaments.*')],
            ];
        }
    @endphp

    <div x-data="{ mobileMenuOpen: false }" class="min-h-screen bg-slate-950 text-slate-100">
        @auth
            <header class="sticky top-0 z-50 border-b border-slate-800 bg-slate-950/95 backdrop-blur">
                <div class="flex w-full items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-700 bg-slate-900 text-sm font-black text-emerald-400">LS</span>
                        <span>
                            <span class="block text-sm uppercase tracking-[0.22em] text-slate-400">SaaS Platform</span>
                            <span class="block text-lg font-black text-emerald-400">Logi-Sport</span>
                        </span>
                    </a>

                    <nav class="hidden items-center gap-2 lg:flex">
                        @foreach($navItems as $item)
                            <a
                                href="{{ $item['href'] }}"
                                class="rounded-2xl px-4 py-2 text-sm font-semibold transition {{ !empty($item['disabled']) ? 'pointer-events-none cursor-not-allowed text-slate-500 opacity-50' : ($item['active'] ? 'bg-emerald-500 text-slate-950' : 'text-slate-300 hover:bg-slate-800 hover:text-white') }}"
                            >
                                {{ $item['label'] }}
                                @if(!empty($item['badge']) && $item['badge'] > 0)
                                    <span class="ml-2 rounded-full bg-slate-950/20 px-2 py-0.5 text-[11px] font-black">{{ $item['badge'] }}</span>
                                @endif
                            </a>
                        @endforeach
                    </nav>

                    <div class="flex items-center gap-3">
                        <div class="hidden items-center gap-3 rounded-2xl border border-slate-700 bg-slate-900/80 px-4 py-2 shadow-sm sm:flex">
                            <div class="min-w-0 text-right">
                                <p class="truncate text-sm font-semibold text-slate-100">{{ $user->name }}</p>
                                <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400">{{ $role }}</p>
                            </div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 text-sm font-bold text-emerald-300">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>

                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-900 text-slate-200 lg:hidden"
                            @click="mobileMenuOpen = ! mobileMenuOpen"
                            aria-label="Open navigation menu"
                        >
                            <span class="flex flex-col gap-1">
                                <span class="block h-0.5 w-5 rounded-full bg-current"></span>
                                <span class="block h-0.5 w-5 rounded-full bg-current"></span>
                                <span class="block h-0.5 w-5 rounded-full bg-current"></span>
                            </span>
                        </button>

                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-2xl border border-slate-700 bg-slate-900 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:bg-slate-800"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <div x-cloak x-show="mobileMenuOpen" x-transition class="border-t border-slate-800 bg-slate-950 lg:hidden">
                    <div class="flex w-full flex-col gap-2 px-4 py-4 sm:px-6">
                        @foreach($navItems as $item)
                            <a
                                href="{{ $item['href'] }}"
                                class="rounded-2xl px-4 py-3 text-sm font-semibold transition {{ !empty($item['disabled']) ? 'pointer-events-none cursor-not-allowed text-slate-500 opacity-50' : ($item['active'] ? 'bg-emerald-500 text-slate-950' : 'text-slate-300 hover:bg-slate-800 hover:text-white') }}"
                                @click="mobileMenuOpen = false"
                            >
                                <span class="flex items-center justify-between gap-3">
                                    <span>{{ $item['label'] }}</span>
                                    @if(!empty($item['badge']) && $item['badge'] > 0)
                                        <span class="rounded-full bg-slate-950/20 px-2 py-0.5 text-[11px] font-black">{{ $item['badge'] }}</span>
                                    @endif
                                </span>
                            </a>
                        @endforeach

                        <form method="POST" action="{{ route('logout') }}" class="pt-2">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-800"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>
        @endauth

        <main class="w-full flex-1 p-4 sm:p-6 lg:p-8">
            @auth
                <div class="mb-5 lg:mb-6">
                    <h1 class="text-2xl font-black text-slate-100">{{ $title ?? 'Dashboard' }}</h1>
                    <p class="mt-1 text-sm text-slate-400">{{ $subtitle ?? 'Welcome back to Logi-Sport.' }}</p>
                </div>
            @endauth

            {{ $slot }}
        </main>
    </div>
</body>
</html>
