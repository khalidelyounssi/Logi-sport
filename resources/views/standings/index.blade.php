<x-app-layout>
    <x-slot name="title">Standings</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} ranking table and performance summary.</x-slot>

    @php
        $leaders = $standings->take(3);
        $role = auth()->user()->role;
        $isOrganizer = $role === 'organizer';
        $isAdmin = $role === 'admin';
        $isPlayer = $role === 'player';
        $canManage = in_array($role, ['organizer', 'admin'], true);

        $isElimination = $tournament->type === 'elimination';
        $isRoundRobin = $tournament->type === 'round_robin';
        $availableTournaments = $availableTournaments ?? collect();
    @endphp

    <div class="space-y-6">
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        @if($availableTournaments->isNotEmpty())
            <x-ui.card>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tournament Selector</p>
                        <p class="mt-1 text-sm text-slate-300">Choisissez le tournoi que vous voulez consulter.</p>
                    </div>

                    <div class="w-full sm:w-auto">
                        <label for="tournament_switcher" class="sr-only">Select tournament</label>
                        <select
                            id="tournament_switcher"
                            class="ui-select min-w-[280px]"
                            onchange="if (this.value) window.location.href = this.value"
                        >
                            @foreach($availableTournaments as $item)
                                <option
                                    value="{{ route('tournaments.standings.index', $item) }}"
                                    @selected($item->id === $tournament->id)
                                >
                                    {{ $item->title }}{{ $item->sport?->name ? ' • '.$item->sport->name : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-ui.card>
        @endif

        <div class="ls-flow-banner ls-flow-banner-step-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="ls-flow-label">
                        {{ $canManage ? 'Tournament Flow' : 'Player View' }}
                    </p>

                    <h2 class="ls-flow-title">{{ $tournament->title }}</h2>

                    <p class="ls-flow-copy">
                        @if($canManage)
                            @if($isElimination)
                                Elimination bracket summary based on finished matches.
                            @else
                                Step 4/4: Live ranking based on scored matches.
                            @endif
                        @else
                            @if($isElimination)
                                Follow the knockout progress and participant performance.
                            @else
                                Follow the current rankings and your tournament progress.
                            @endif
                        @endif
                    </p>
                </div>

                <div class="ls-flow-actions">
                    @if($canManage)
                        <a href="{{ route('tournaments.participants.index', $tournament) }}" class="ls-flow-pill">Participants</a>
                        <a href="{{ route('tournaments.matches.index', $tournament) }}" class="ls-flow-pill">Matches</a>
                    @endif

                    @if($isPlayer && Route::has('player.tournaments'))
                        <a href="{{ route('player.tournaments') }}" class="ls-flow-pill">My Tournaments</a>
                    @endif

                    @if($isPlayer && Route::has('player.matches'))
                        <a href="{{ route('player.matches') }}" class="ls-flow-pill">My Matches</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tournament</p>
                <h3 class="mt-2 text-xl font-black">{{ $tournament->title }}</h3>
            </x-ui.card>

            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Sport</p>
                <h3 class="mt-2 text-xl font-black">{{ $tournament->sport?->name ?? '-' }}</h3>
            </x-ui.card>

            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">
                    {{ $isElimination ? 'Qualified Participants' : 'Participants' }}
                </p>
                <h3 class="mt-2 text-xl font-black">{{ $standings->count() }}</h3>
            </x-ui.card>
        </div>

        @if($leaders->isNotEmpty())
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                @foreach($leaders as $index => $leader)
                    @php
                        $isCurrentUser = $leader->participant?->user_id === auth()->id();
                    @endphp

                    <x-ui.card class="{{ $index === 0 ? 'border-amber-300/30 bg-amber-400/10' : '' }} {{ $isCurrentUser ? 'ring-2 ring-emerald-400/40' : '' }}">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">
                                    {{ $isElimination ? 'Top Performer ' . ($index + 1) : 'Rank ' . ($index + 1) }}
                                </p>

                                <h4 class="mt-1 text-lg font-black text-white">
                                    {{ $leader->participant?->name }}
                                    @if($isCurrentUser)
                                        <span class="ml-2 text-sm font-semibold text-emerald-300">(You)</span>
                                    @endif
                                </h4>
                            </div>

                            <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                Top {{ $index + 1 }}
                            </span>
                        </div>

                        @if($isElimination)
                            <p class="mt-3 text-sm text-slate-400">
                                {{ $leader->won }} wins <span class="mx-2 ls-separator-dot align-middle"></span> {{ $leader->lost }} losses <span class="mx-2 ls-separator-dot align-middle"></span> {{ $leader->played }} played
                            </p>
                        @else
                            <p class="mt-3 text-sm text-slate-400">
                                {{ $leader->points }} pts <span class="mx-2 ls-separator-dot align-middle"></span> {{ $leader->won }}W / {{ $leader->draw }}D / {{ $leader->lost }}L
                            </p>
                        @endif
                    </x-ui.card>
                @endforeach
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-500">
                @if($canManage)
                    @if($isElimination)
                        Knockout performance is ranked by wins, losses, and matches played.
                    @else
                        Automatically ranked by points, wins, and losses.
                    @endif
                @else
                    @if($isElimination)
                        Rankings update automatically after official knockout match scores are saved.
                    @else
                        Rankings are updated automatically after official match scores are saved.
                    @endif
                @endif
            </p>

            @if($canManage)
                <form action="{{ route('tournaments.standings.recalculate', $tournament) }}" method="POST">
                    @csrf
                    <x-ui.button type="submit" variant="primary">
                        <span>Recalculate Standings</span>
                    </x-ui.button>
                </form>
            @endif
        </div>

        <x-ui.card padding="p-0">
            <x-ui.table>
                <thead class="bg-slate-950/70 text-xs uppercase tracking-[0.18em] text-slate-500">
                    <tr>
                        <th class="p-5">Rank</th>
                        <th class="p-5">Participant</th>

                        @if($isRoundRobin)
                            <th class="p-5">Points</th>
                        @endif

                        <th class="p-5">Played</th>
                        <th class="p-5">Won</th>

                        @if($isRoundRobin)
                            <th class="p-5">Draw</th>
                        @endif

                        <th class="p-5">Lost</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($standings as $index => $standing)
                        @php
                            $isCurrentUser = $standing->participant?->user_id === auth()->id();
                        @endphp

                        <tr class="border-t border-slate-800/80 {{ $index < 3 ? 'bg-slate-900/40' : '' }} {{ $isCurrentUser ? 'bg-emerald-400/5' : '' }}">
                            <td class="p-5">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold {{ $index === 0 ? 'bg-amber-400/15 text-amber-300' : 'bg-slate-800 text-slate-300' }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>

                            <td class="p-5 font-semibold text-white">
                                {{ $standing->participant?->name }}
                                @if($isCurrentUser)
                                    <span class="ml-2 text-xs font-bold uppercase tracking-[0.15em] text-emerald-300">You</span>
                                @endif
                            </td>

                            @if($isRoundRobin)
                                <td class="p-5 text-lg font-black text-emerald-300">{{ $standing->points }}</td>
                            @endif

                            <td class="p-5">{{ $standing->played }}</td>
                            <td class="p-5 font-semibold text-emerald-600">{{ $standing->won }}</td>

                            @if($isRoundRobin)
                                <td class="p-5 font-semibold text-amber-600">{{ $standing->draw }}</td>
                            @endif

                            <td class="p-5 font-semibold text-rose-300">{{ $standing->lost }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isRoundRobin ? 7 : 5 }}" class="p-10 text-center">
                                <p class="text-lg font-semibold text-slate-200">No standings yet</p>
                                <p class="mt-1 text-sm text-slate-500">
                                    Standings appear after matches are generated and scores are saved.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>
    </div>
</x-app-layout>
