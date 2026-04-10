<x-app-layout>
    <x-slot name="title">Organizer Dashboard</x-slot>
    <x-slot name="subtitle">Plan tournaments, manage participants, and track competition progress.</x-slot>

    <div class="space-y-6">
        <x-ui.card class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Organizer Workspace</p>
                    <h2 class="mt-1 text-2xl font-black">Tournament Operations</h2>
                    <p class="mt-1 text-sm text-blue-100">
                        Use the flow: Tournament → Participants → Matches → Standings.
                    </p>
                </div>

                <x-ui.button as="a" :href="route('tournaments.create')" variant="secondary" size="lg">
                    <span>➕</span>
                    <span>Create Tournament</span>
                </x-ui.button>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card title="Active Tournaments" :value="$activeTournaments" hint="In progress + upcoming" />
            <x-stat-card title="Registered Teams" :value="$registeredTeams" hint="Across all tournaments" tone="slate" />
            <x-stat-card title="Matches Played" :value="$matchesPlayed" hint="Finished matches" tone="emerald" />
            <x-stat-card title="Pending Scores" :value="$pendingScores" hint="Scheduled + in progress" tone="amber" />
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <x-ui.card class="xl:col-span-2">
                <h3 class="text-lg font-black text-slate-900">Quick Navigation</h3>
                <p class="mt-1 text-sm text-slate-500">Jump directly into your tournament workflow.</p>

                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <x-ui.button as="a" :href="route('tournaments.index')" variant="secondary" size="lg" class="justify-start">
                        🏆 Tournaments
                    </x-ui.button>

                    <x-ui.button
                        as="a"
                        :href="$currentTournament ? route('tournaments.participants.index', $currentTournament) : route('tournaments.index')"
                        variant="secondary"
                        size="lg"
                        class="justify-start"
                    >
                        👥 Participants
                    </x-ui.button>

                    <x-ui.button
                        as="a"
                        :href="$currentTournament ? route('tournaments.matches.index', $currentTournament) : route('tournaments.index')"
                        variant="secondary"
                        size="lg"
                        class="justify-start"
                    >
                        ⚔️ Matches
                    </x-ui.button>

                    <x-ui.button
                        as="a"
                        :href="$currentTournament ? route('tournaments.standings.index', $currentTournament) : route('tournaments.index')"
                        variant="secondary"
                        size="lg"
                        class="justify-start"
                    >
                        🥇 Standings
                    </x-ui.button>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-900">Latest Tournaments</h3>
                <div class="mt-4 space-y-3">
                    @forelse($recentTournaments as $tournament)
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $tournament->title }}</p>
                                    <p class="text-sm text-slate-500">{{ $tournament->sport?->name ?? 'No sport' }}</p>
                                </div>

                                <x-ui.badge variant="info">
                                    {{ $tournament->status }}
                                </x-ui.badge>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-500">
                            No tournaments yet.
                        </div>
                    @endforelse
                </div>
            </x-ui.card>
        </div>

        <x-ui.card padding="p-0">
            <div class="border-b border-slate-100 px-6 py-5">
                <h3 class="text-lg font-black text-slate-900">Recent Updates</h3>
                <p class="text-sm text-slate-500">Latest match and tournament activity.</p>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentUpdates as $match)
                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ $match->tournament?->title ?? 'Tournament' }}
                            </p>
                            <p class="text-sm text-slate-500">
                                {{ $match->participantA?->name ?? '-' }} vs {{ $match->participantB?->name ?? '-' }}
                                @if(!is_null($match->score_a) || !is_null($match->score_b))
                                    • {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                @endif
                            </p>
                        </div>

                        <x-ui.badge :status="$match->status">
                            {{ str_replace('_', ' ', $match->status) }}
                        </x-ui.badge>
                    </div>
                @empty
                    <div class="px-6 py-6 text-sm text-slate-500">
                        No recent updates available.
                    </div>
                @endforelse
            </div>
        </x-ui.card>
    </div>
</x-app-layout>