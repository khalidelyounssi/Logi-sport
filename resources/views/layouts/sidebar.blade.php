@php
    $mobile = $mobile ?? false;
    $user = auth()->user();
    $role = $user->role;

    $currentTournament = request()->route('tournament');

    if (! $currentTournament instanceof \App\Models\Tournament) {
        $currentTournament = null;
    }

    if ($role === 'organizer' && ! $currentTournament) {
        $currentTournament = $user->tournaments()->latest('id')->first();
    }

    $organizerHasTournament = $currentTournament instanceof \App\Models\Tournament;

    $adminUsersEnabled = Route::has('admin.users.index');
    $adminStatsEnabled = Route::has('admin.statistics.index');
    $playerTournamentsEnabled = Route::has('player.tournaments.index');

    $baseLinkClass = 'group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition';

    $linkClass = static function (bool $active = false, bool $disabled = false) use ($baseLinkClass): string {
        if ($disabled) {
            return $baseLinkClass . ' pointer-events-none opacity-45 text-slate-400';
        }

        if ($active) {
            return $baseLinkClass . ' bg-blue-600 text-white shadow-sm';
        }

        return $baseLinkClass . ' text-slate-600 hover:bg-slate-100 hover:text-slate-900';
    };
@endphp

<aside class="{{ $mobile ? 'h-full w-full border-r border-slate-200 bg-white' : 'sticky top-0 h-screen border-r border-slate-200 bg-white/95 backdrop-blur' }}">
    <div class="flex h-full flex-col">
        <div class="border-b border-slate-100 px-6 py-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-100 text-lg text-blue-700">⚽</span>
                <span>
                    <span class="block text-sm uppercase tracking-[0.22em] text-slate-400">SaaS Platform</span>
                    <span class="block text-lg font-black text-blue-700">Logi-Sport</span>
                </span>
            </a>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-5">
            @if($role === 'organizer')
                <a href="{{ route('organizer.dashboard') }}" class="{{ $linkClass(request()->routeIs('organizer.dashboard')) }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('tournaments.index') }}" class="{{ $linkClass(request()->routeIs('tournaments.index', 'tournaments.create', 'tournaments.show', 'tournaments.edit')) }}">
                    <span>🏆</span>
                    <span>Tournaments</span>
                </a>

                <a href="{{ $organizerHasTournament ? route('tournaments.participants.index', $currentTournament) : route('tournaments.index') }}" class="{{ $linkClass(request()->routeIs('tournaments.participants.*')) }}">
                    <span>👥</span>
                    <span>Participants</span>
                </a>

                <a href="{{ $organizerHasTournament ? route('tournaments.matches.index', $currentTournament) : route('tournaments.index') }}" class="{{ $linkClass(request()->routeIs('tournaments.matches.*')) }}">
                    <span>⚔️</span>
                    <span>Matches</span>
                </a>

                <a href="{{ $organizerHasTournament ? route('tournaments.standings.index', $currentTournament) : route('tournaments.index') }}" class="{{ $linkClass(request()->routeIs('tournaments.standings.*')) }}">
                    <span>🥇</span>
                    <span>Standings</span>
                </a>
            @endif

            @if($role === 'referee')
                <a href="{{ route('referee.dashboard') }}" class="{{ $linkClass(request()->routeIs('referee.dashboard')) }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('referee.matches.index') }}" class="{{ $linkClass(request()->routeIs('referee.matches.*')) }}">
                    <span>🧑‍⚖️</span>
                    <span>My Matches</span>
                </a>
            @endif

            @if($role === 'player')
                <a href="{{ route('player.dashboard') }}" class="{{ $linkClass(request()->routeIs('player.dashboard')) }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ $playerTournamentsEnabled ? route('player.tournaments.index') : '#' }}" class="{{ $linkClass($playerTournamentsEnabled && request()->routeIs('player.tournaments.*'), ! $playerTournamentsEnabled) }}">
                    <span>🎮</span>
                    <span>My Tournaments</span>
                </a>
            @endif

            @if($role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="{{ $linkClass(request()->routeIs('admin.dashboard')) }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ $adminUsersEnabled ? route('admin.users.index') : '#' }}" class="{{ $linkClass($adminUsersEnabled && request()->routeIs('admin.users.*'), ! $adminUsersEnabled) }}">
                    <span>👤</span>
                    <span>Users</span>
                </a>

                <a href="{{ $adminStatsEnabled ? route('admin.statistics.index') : '#' }}" class="{{ $linkClass($adminStatsEnabled && request()->routeIs('admin.statistics.*'), ! $adminStatsEnabled) }}">
                    <span>📈</span>
                    <span>Statistics</span>
                </a>
            @endif
        </nav>

        <div class="border-t border-slate-100 px-4 py-5">
            <div class="mb-4 flex items-center gap-3 rounded-2xl bg-slate-50 p-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-700">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">{{ $role }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    <span>🚪</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
