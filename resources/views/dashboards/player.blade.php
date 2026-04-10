<x-app-layout>
    <x-slot name="title">Player Dashboard</x-slot>
    <x-slot name="subtitle">Follow your tournaments, match results, and performance trends.</x-slot>

    <div class="space-y-6">
        <x-ui.card class="bg-gradient-to-r from-blue-700 to-indigo-700 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Player Space</p>
                    <h2 class="mt-1 text-2xl font-black">Performance Hub</h2>
                    <p class="mt-1 text-sm text-blue-100">
                        Track rankings, recent matches, and your tournament history.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-ui.button as="a" :href="route('player.tournaments')" variant="secondary" size="lg">
                        🎮 My Tournaments
                    </x-ui.button>

                    <x-ui.button as="a" :href="route('player.matches')" variant="secondary" size="lg">
                        ⚽ My Matches
                    </x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card title="Matches Played" :value="$matchesPlayed" hint="Finished matches" />
            <x-stat-card title="Wins" :value="$wins" hint="Across linked participations" tone="emerald" />
            <x-stat-card title="Goals / Points" :value="$goalsOrPoints" hint="Overall contribution" tone="blue" />
            <x-stat-card title="Rank" :value="$rank" hint="Best current standing" tone="amber" />
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <x-ui.card class="xl:col-span-2" padding="p-0">
                <div class="border-b border-slate-100 px-6 py-5">
                    <h3 class="text-lg font-black text-slate-900">Recent Matches</h3>
                    <p class="text-sm text-slate-500">Your latest activity and outcomes.</p>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($recentMatches as $match)
                        @php
                            $isA = $match->participantA?->user_id === auth()->id();
                            $isB = $match->participantB?->user_id === auth()->id();

                            $result = 'Pending';
                            $variant = 'info';

                            if ($match->status === 'finished') {
                                if (
                                    ($isA && ($match->score_a ?? 0) > ($match->score_b ?? 0)) ||
                                    ($isB && ($match->score_b ?? 0) > ($match->score_a ?? 0))
                                ) {
                                    $result = 'Win';
                                    $variant = 'success';
                                } elseif (($match->score_a ?? 0) === ($match->score_b ?? 0)) {
                                    $result = 'Draw';
                                    $variant = 'warning';
                                } else {
                                    $result = 'Loss';
                                    $variant = 'danger';
                                }
                            }
                        @endphp

                        <div class="flex items-center justify-between px-6 py-4">
                            <div>
                                <p class="font-semibold text-slate-800">
                                    {{ $match->tournament?->title ?? 'Tournament' }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    {{ $match->participantA?->name }} vs {{ $match->participantB?->name }}
                                    @if(!is_null($match->score_a) || !is_null($match->score_b))
                                        • {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                    @endif
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $match->match_date?->format('Y-m-d H:i') ?? 'No date' }}
                                    @if($match->location)
                                        • {{ $match->location }}
                                    @endif
                                </p>
                            </div>

                            <x-ui.badge variant="{{ $variant }}">
                                {{ $result }}
                            </x-ui.badge>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-sm text-slate-500">
                            No recent matches found.
                        </div>
                    @endforelse
                </div>
            </x-ui.card>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-900">My Tournaments</h3>
                <p class="mt-1 text-sm text-slate-500">Tournaments where you are registered.</p>

                <div class="mt-4 space-y-3">
                    @forelse($myTournaments->take(5) as $tournament)
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $tournament->title }}</p>
                                <p class="text-sm text-slate-500">{{ $tournament->sport?->name ?? 'No sport' }}</p>
                            </div>

                            <x-ui.badge variant="info">
                                {{ $tournament->status }}
                            </x-ui.badge>
                        </div>
                    @empty
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-500">
                            You are not linked to any tournament yet.
                        </div>
                    @endforelse
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>