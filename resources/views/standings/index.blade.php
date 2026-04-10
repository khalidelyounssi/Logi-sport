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
    @endphp

    <div class="space-y-6">
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <x-ui.card class="bg-gradient-to-r from-emerald-600 to-blue-700 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-100">
                        {{ $canManage ? 'Tournament Flow' : 'Player View' }}
                    </p>

                    <h2 class="mt-1 text-2xl font-black">{{ $tournament->title }}</h2>

                    <p class="mt-1 text-sm text-emerald-100">
                        @if($canManage)
                            Step 4/4: Live ranking based on scored matches.
                        @else
                            Follow the current rankings and your tournament progress.
                        @endif
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @if($canManage)
                        <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary" size="sm">
                            Participants
                        </x-ui.button>

                        <x-ui.button as="a" :href="route('tournaments.matches.index', $tournament)" variant="secondary" size="sm">
                            Matches
                        </x-ui.button>
                    @endif

                    @if($isPlayer && Route::has('player.tournaments'))
                        <x-ui.button as="a" :href="route('player.tournaments')" variant="secondary" size="sm">
                            My Tournaments
                        </x-ui.button>
                    @endif

                    @if($isPlayer && Route::has('player.matches'))
                        <x-ui.button as="a" :href="route('player.matches')" variant="secondary" size="sm">
                            My Matches
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </x-ui.card>

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
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Participants</p>
                <h3 class="mt-2 text-xl font-black">{{ $standings->count() }}</h3>
            </x-ui.card>
        </div>

        @if($leaders->isNotEmpty())
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                @foreach($leaders as $index => $leader)
                    @php
                        $isCurrentUser = $leader->participant?->user_id === auth()->id();
                    @endphp

                    <x-ui.card class="{{ $index === 0 ? 'border-yellow-300 bg-yellow-50' : '' }} {{ $isCurrentUser ? 'ring-2 ring-blue-300' : '' }}">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Rank {{ $index + 1 }}</p>
                                <h4 class="mt-1 text-lg font-black text-slate-900">
                                    {{ $leader->participant?->name }}
                                    @if($isCurrentUser)
                                        <span class="ml-2 text-sm font-semibold text-blue-600">(You)</span>
                                    @endif
                                </h4>
                            </div>

                            <span class="text-2xl">
                                {{ $index === 0 ? '🏆' : ($index === 1 ? '🥈' : '🥉') }}
                            </span>
                        </div>

                        <p class="mt-3 text-sm text-slate-600">
                            {{ $leader->points }} pts • {{ $leader->won }}W / {{ $leader->draw }}D / {{ $leader->lost }}L
                        </p>
                    </x-ui.card>
                @endforeach
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-500">
                @if($canManage)
                    Automatically ranked by points, wins, and losses.
                @else
                    Rankings are updated automatically after official match scores are saved.
                @endif
            </p>

            @if($canManage)
                <form action="{{ route('tournaments.standings.recalculate', $tournament) }}" method="POST">
                    @csrf
                    <x-ui.button type="submit" variant="primary">
                        <span>🔄</span>
                        <span>Recalculate Standings</span>
                    </x-ui.button>
                </form>
            @endif
        </div>

        <x-ui.card padding="p-0">
            <x-ui.table>
                <thead class="bg-slate-50 text-xs uppercase tracking-[0.18em] text-slate-400">
                    <tr>
                        <th class="p-5">Rank</th>
                        <th class="p-5">Participant</th>
                        <th class="p-5">Points</th>
                        <th class="p-5">Played</th>
                        <th class="p-5">Won</th>
                        <th class="p-5">Draw</th>
                        <th class="p-5">Lost</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($standings as $index => $standing)
                        @php
                            $isCurrentUser = $standing->participant?->user_id === auth()->id();
                        @endphp

                        <tr class="border-t border-slate-100 {{ $index < 3 ? 'bg-blue-50/40' : '' }} {{ $isCurrentUser ? 'bg-emerald-50/60' : '' }}">
                            <td class="p-5">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>

                            <td class="p-5 font-semibold text-slate-900">
                                {{ $standing->participant?->name }}
                                @if($isCurrentUser)
                                    <span class="ml-2 text-xs font-bold uppercase tracking-[0.15em] text-emerald-600">You</span>
                                @endif
                            </td>

                            <td class="p-5 text-lg font-black text-blue-700">{{ $standing->points }}</td>
                            <td class="p-5">{{ $standing->played }}</td>
                            <td class="p-5 font-semibold text-emerald-600">{{ $standing->won }}</td>
                            <td class="p-5 font-semibold text-amber-600">{{ $standing->draw }}</td>
                            <td class="p-5 font-semibold text-red-600">{{ $standing->lost }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center">
                                <p class="text-lg font-semibold text-slate-700">No standings yet</p>
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