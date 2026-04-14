<x-app-layout>
    <x-slot name="title">Matches</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} schedule, assignments, and score status.</x-slot>

    @php
        $logoUrl = static function (?string $logo): ?string {
            if (! $logo) {
                return null;
            }

            if (str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://')) {
                return $logo;
            }

            return \Illuminate\Support\Facades\Storage::url($logo);
        };

        $availableTournaments = $availableTournaments ?? collect();
    @endphp

    <div class="space-y-6">
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        @if($availableTournaments->isNotEmpty())
            <x-ui.card>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tournament Selector</p>
                        <p class="mt-1 text-sm text-slate-300">Choisissez le tournoi pour voir ses matchs.</p>
                    </div>

                    <div class="w-full sm:w-auto">
                        <label for="matches_tournament_switcher" class="sr-only">Select tournament</label>
                        <select
                            id="matches_tournament_switcher"
                            class="ui-select min-w-[280px]"
                            onchange="if (this.value) window.location.href = this.value"
                        >
                            @foreach($availableTournaments as $item)
                                <option
                                    value="{{ route('tournaments.matches.index', $item) }}"
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

        <x-ui.card class="bg-gradient-to-r from-slate-900 to-blue-900 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Tournament Flow</p>
                    <h2 class="mt-1 text-2xl font-black">{{ $tournament->title }}</h2>
                    <p class="mt-1 text-sm text-slate-300">Step 3/4: Schedule and track all matches.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary" size="sm">Participants</x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.standings.index', $tournament)" variant="secondary" size="sm">Standings</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <span>Total matches: {{ $matches->count() }}</span>
                <span>•</span>
                <span>Finished: {{ $matches->where('status', 'finished')->count() }}</span>
                <span>•</span>
                <span>Scheduled: {{ $matches->where('status', 'scheduled')->count() }}</span>
            </div>

            <div class="flex flex-wrap gap-2">
                @if(auth()->user()->role === 'organizer')
                    <x-ui.button as="a" :href="route('tournaments.matches.create', $tournament)" variant="primary">
                        <span>➕</span>
                        <span>Create Match</span>
                    </x-ui.button>

                    @if($tournament->type === 'round_robin')
                        <form action="{{ route('tournaments.generateMatches', $tournament) }}" method="POST" onsubmit="return confirm('Regenerate matches? Existing matches will be replaced.')">
                            @csrf
                            <x-ui.button type="submit" variant="success">
                                <span>⚙️</span>
                                <span>Generate Round Robin</span>
                            </x-ui.button>
                        </form>
                    @endif
                @endif

                <x-ui.button as="a" :href="route('tournaments.standings.index', $tournament)" variant="dark">
                    View Standings
                </x-ui.button>
            </div>
        </div>

        <x-ui.card>
            @forelse($matches as $match)
                @php
                    $teamALogo = $logoUrl($match->participantA?->logo);
                    $teamBLogo = $logoUrl($match->participantB?->logo);
                    $hasScore = !is_null($match->score_a) && !is_null($match->score_b);
                @endphp

                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-4 mb-4">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($teamALogo)
                                <img src="{{ $teamALogo }}" alt="{{ $match->participantA?->name }}" class="h-12 w-12 rounded-full object-cover border border-slate-700">
                            @else
                                <div class="h-12 w-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 font-bold">
                                    {{ strtoupper(substr($match->participantA?->name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                            <p class="font-semibold text-slate-100 truncate">{{ $match->participantA?->name ?? 'Team A' }}</p>
                        </div>

                        <div class="text-center shrink-0">
                            @if($hasScore)
                                <p class="text-2xl font-black text-emerald-300">{{ $match->score_a }} - {{ $match->score_b }}</p>
                            @elseif($match->status === 'finished')
                                <p class="text-sm font-bold text-amber-300">No score</p>
                            @else
                                <p class="text-xl font-black text-slate-300">VS</p>
                            @endif
                            <p class="text-xs text-slate-500 mt-1">{{ $match->match_date?->format('d M • H:i') ?? 'Date TBD' }}</p>
                        </div>

                        <div class="flex items-center gap-3 min-w-0 flex-row-reverse">
                            @if($teamBLogo)
                                <img src="{{ $teamBLogo }}" alt="{{ $match->participantB?->name }}" class="h-12 w-12 rounded-full object-cover border border-slate-700">
                            @else
                                <div class="h-12 w-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 font-bold">
                                    {{ strtoupper(substr($match->participantB?->name ?? 'B', 0, 1)) }}
                                </div>
                            @endif
                            <p class="font-semibold text-slate-100 truncate">{{ $match->participantB?->name ?? 'Team B' }}</p>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-t border-slate-800 flex items-center justify-between text-sm gap-2 flex-wrap">
                        <p class="text-slate-400">{{ $match->referee?->name ?? 'No referee' }}</p>
                        <div class="flex items-center gap-2 flex-wrap">
                            <x-ui.badge :status="$match->status">{{ str_replace('_', ' ', $match->status) }}</x-ui.badge>
                            <x-ui.button as="a" :href="route('tournaments.matches.show', [$tournament, $match])" variant="dark" size="sm">View</x-ui.button>
                            <x-ui.button as="a" :href="route('tournaments.matches.edit', [$tournament, $match])" variant="secondary" size="sm">Edit</x-ui.button>
                            @if(auth()->user()->role === 'organizer')
                                <form action="{{ route('tournaments.matches.destroy', [$tournament, $match]) }}" method="POST" onsubmit="return confirm('Delete this match?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button type="submit" variant="danger-soft" size="sm">Delete</x-ui.button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <x-ui.empty-state title="No matches available" description="Generate matches from participants or create them manually.">
                    @if(auth()->user()->role === 'organizer')
                        <x-ui.button as="a" :href="route('tournaments.matches.create', $tournament)" variant="primary">Create Match</x-ui.button>
                        @if($tournament->type === 'round_robin')
                            <form action="{{ route('tournaments.generateMatches', $tournament) }}" method="POST">
                                @csrf
                                <x-ui.button type="submit" variant="success">Generate Round Robin</x-ui.button>
                            </form>
                        @endif
                    @endif
                </x-ui.empty-state>
            @endforelse
        </x-ui.card>
    </div>
</x-app-layout>
