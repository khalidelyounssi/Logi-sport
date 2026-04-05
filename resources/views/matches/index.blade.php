<x-app-layout>
    <x-slot name="title">Matches</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} schedule, assignments, and score status.</x-slot>

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

        <x-ui.card padding="p-0">
            <x-ui.table>
                <thead class="bg-slate-50 text-xs uppercase tracking-[0.18em] text-slate-400">
                    <tr>
                        <th class="p-5">Participant A</th>
                        <th class="p-5">Participant B</th>
                        <th class="p-5">Date</th>
                        <th class="p-5">Score</th>
                        <th class="p-5">Status</th>
                        <th class="p-5">Referee</th>
                        <th class="p-5">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($matches as $match)
                        <tr class="border-t border-slate-100">
                            <td class="p-5 font-semibold text-slate-900">{{ $match->participantA?->name ?? '-' }}</td>
                            <td class="p-5 font-semibold text-slate-900">{{ $match->participantB?->name ?? '-' }}</td>
                            <td class="p-5 text-slate-600">{{ $match->match_date?->format('Y-m-d H:i') ?? '-' }}</td>
                            <td class="p-5 font-semibold text-slate-700">{{ $match->score_a ?? '-' }} - {{ $match->score_b ?? '-' }}</td>
                            <td class="p-5">
                                <x-ui.badge :status="$match->status">
                                    {{ str_replace('_', ' ', $match->status) }}
                                </x-ui.badge>
                            </td>
                            <td class="p-5 text-slate-600">{{ $match->referee?->name ?? 'Not assigned' }}</td>
                            <td class="p-5">
                                <div class="flex flex-wrap gap-2">
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center">
                                <p class="text-lg font-semibold text-slate-700">No matches available</p>
                                <p class="mt-1 text-sm text-slate-500">Generate matches from participants or create them manually.</p>
                                @if(auth()->user()->role === 'organizer')
                                    <div class="mt-4 flex items-center justify-center gap-2">
                                        <x-ui.button as="a" :href="route('tournaments.matches.create', $tournament)" variant="primary">Create Match</x-ui.button>
                                        @if($tournament->type === 'round_robin')
                                            <form action="{{ route('tournaments.generateMatches', $tournament) }}" method="POST">
                                                @csrf
                                                <x-ui.button type="submit" variant="success">Generate Round Robin</x-ui.button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>
    </div>
</x-app-layout>
