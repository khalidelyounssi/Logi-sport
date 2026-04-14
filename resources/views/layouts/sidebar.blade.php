@php
    $mobile = $mobile ?? false;
    $user = auth()->user();
    $role = $user->role;

    $currentTournament = request()->route('tournament');

    if (!$currentTournament instanceof \App\Models\Tournament) {
        $currentTournament = null;
    }

    if ($role === 'organizer' && !$currentTournament) {
        $currentTournament = $user->tournaments()->latest('id')->first();
    }

    $organizerHasTournament = $currentTournament instanceof \App\Models\Tournament;

    $playerTournamentsEnabled = Route::has('player.tournaments');
    $playerMatchesEnabled = Route::has('player.matches');
    $notificationsEnabled = Route::has('notifications.index');
    $unreadNotificationsCount = $notificationsEnabled ? $user->notifications()->where('is_read', false)->count() : 0;

    $baseLinkClass = 'group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition';

    $linkClass = static function (bool $active = false, bool $disabled = false) use ($baseLinkClass): string {
        if ($disabled) {
            return $baseLinkClass . ' pointer-events-none opacity-45 text-slate-500';
        }

        if ($active) {
            return $baseLinkClass . ' bg-emerald-500 text-slate-900 shadow-sm';
        }

        return $baseLinkClass . ' text-slate-300 hover:bg-slate-800 hover:text-white';
    };
@endphp

<aside class="{{ $mobile ? 'h-full w-full border-r border-slate-800 bg-slate-950' : 'sticky top-0 h-screen border-r border-slate-800 bg-slate-950/95 backdrop-blur' }}">
    <div class="flex h-full flex-col">
        <div class="border-b border-slate-800 px-6 py-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/20 text-lg text-emerald-300 border border-emerald-400/30">⚽</span>
                <span>
                    <span class="block text-sm uppercase tracking-[0.22em] text-slate-400">SaaS Platform</span>
                    <span class="block text-lg font-black text-emerald-400">Logi-Sport</span>
                </span>
            </a>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-5">
            @if($role === 'organizer')
                <a href="{{ route('notifications.index') }}"
                   class="{{ $linkClass(request()->routeIs('notifications.*')) }}">
                    <span>🔔</span>
                    <span>Notifications</span>
                    @if($unreadNotificationsCount > 0)
                        <span class="ml-auto rounded-full bg-emerald-500 px-2 py-0.5 text-[11px] font-black text-slate-950">{{ $unreadNotificationsCount }}</span>
                    @endif
                </a>

                <a href="{{ route('organizer.dashboard') }}"
                   class="{{ $linkClass(request()->routeIs('organizer.dashboard')) }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('tournaments.index') }}"
                   class="{{ $linkClass(request()->routeIs('tournaments.index', 'tournaments.create', 'tournaments.show', 'tournaments.edit')) }}">
                    <span>🏆</span>
                    <span>Tournaments</span>
                </a>

                <a href="{{ $organizerHasTournament ? route('tournaments.participants.index', $currentTournament) : route('tournaments.index') }}"
                   class="{{ $linkClass(request()->routeIs('tournaments.participants.*')) }}">
                    <span>👥</span>
                    <span>Participants</span>
                </a>

                <a href="{{ $organizerHasTournament ? route('tournaments.matches.index', $currentTournament) : route('tournaments.index') }}"
                   class="{{ $linkClass(request()->routeIs('tournaments.matches.*')) }}">
                    <span>⚔️</span>
                    <span>Matches</span>
                </a>

                <a href="{{ $organizerHasTournament ? route('tournaments.standings.index', $currentTournament) : route('tournaments.index') }}"
                   class="{{ $linkClass(request()->routeIs('tournaments.standings.*')) }}">
                    <span>🥇</span>
                    <span>Standings</span>
                </a>
            @endif

            @if($role === 'referee')
                <a href="{{ route('notifications.index') }}"
                   class="{{ $linkClass(request()->routeIs('notifications.*')) }}">
                    <span>🔔</span>
                    <span>Notifications</span>
                    @if($unreadNotificationsCount > 0)
                        <span class="ml-auto rounded-full bg-emerald-500 px-2 py-0.5 text-[11px] font-black text-slate-950">{{ $unreadNotificationsCount }}</span>
                    @endif
                </a>

                <a href="{{ route('referee.dashboard') }}"
                   class="{{ $linkClass(request()->routeIs('referee.dashboard')) }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('referee.matches.index') }}"
                   class="{{ $linkClass(request()->routeIs('referee.matches.*')) }}">
                    <span>🧑‍⚖️</span>
                    <span>My Matches</span>
                </a>
            @endif

            @if($role === 'player')
                <a href="{{ route('notifications.index') }}"
                   class="{{ $linkClass(request()->routeIs('notifications.*')) }}">
                    <span>🔔</span>
                    <span>Notifications</span>
                    @if($unreadNotificationsCount > 0)
                        <span class="ml-auto rounded-full bg-emerald-500 px-2 py-0.5 text-[11px] font-black text-slate-950">{{ $unreadNotificationsCount }}</span>
                    @endif
                </a>

                <a href="{{ route('player.dashboard') }}"
                   class="{{ $linkClass(request()->routeIs('player.dashboard')) }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ $playerTournamentsEnabled ? route('player.tournaments') : '#' }}"
                   class="{{ $linkClass($playerTournamentsEnabled && request()->routeIs('player.tournaments'), !$playerTournamentsEnabled) }}">
                    <span>🎮</span>
                    <span>My Tournaments</span>
                </a>

                <a href="{{ $playerMatchesEnabled ? route('player.matches') : '#' }}"
                   class="{{ $linkClass($playerMatchesEnabled && request()->routeIs('player.matches'), !$playerMatchesEnabled) }}">
                    <span>⚽</span>
                    <span>My Matches</span>
                </a>

                <a href="{{ route('player.profile') }}"
                   class="{{ $linkClass(request()->routeIs('player.profile')) }}">
                    <span>👤</span>
                    <span>My Profile</span>
                </a>
            @endif

            @if($role === 'admin')
                <a href="{{ route('notifications.index') }}"
                   class="{{ $linkClass(request()->routeIs('notifications.*')) }}">
                    <span>🔔</span>
                    <span>Notifications</span>
                    @if($unreadNotificationsCount > 0)
                        <span class="ml-auto rounded-full bg-emerald-500 px-2 py-0.5 text-[11px] font-black text-slate-950">{{ $unreadNotificationsCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.dashboard') }}"
                   class="{{ $linkClass(request()->routeIs('admin.dashboard')) }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.users') }}"
                   class="{{ $linkClass(request()->routeIs('admin.users')) }}">
                    <span>👥</span>
                    <span>Users</span>
                </a>

                <a href="{{ route('sports.index') }}"
                   class="{{ $linkClass(request()->routeIs('sports.*')) }}">
                    <span>⚽</span>
                    <span>Sports</span>
                </a>

                
            @endif
        </nav>

        <div class="border-t border-slate-800 px-4 py-5">
            <div class="mb-4 flex items-center gap-3 rounded-2xl bg-slate-900 p-3 border border-slate-800">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/20 text-sm font-bold text-emerald-300 border border-emerald-400/30">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-100">{{ $user->name }}</p>
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">{{ $role }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-sm font-semibold text-slate-200 transition hover:bg-slate-800">
                    <span>🚪</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>