<x-app-layout>
    <x-slot name="title">Organizer Dashboard</x-slot>
    <x-slot name="subtitle">Vue simple pour gérer tournois, matchs et participants.</x-slot>

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
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-ui.card><p class="ls-stat-label">Tournois actifs</p><p class="ls-stat-value text-emerald-300">{{ $activeTournaments }}</p><p class="ls-stat-trend">Currently running</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">Participants</p><p class="ls-stat-value text-cyan-300">{{ $registeredTeams }}</p><p class="ls-stat-trend">Registered entries</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">Matchs joués</p><p class="ls-stat-value text-amber-300">{{ $matchesPlayed }}</p><p class="ls-stat-trend">Results captured</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">Scores en attente</p><p class="ls-stat-value">{{ $pendingScores }}</p><p class="ls-stat-trend">Need review</p></x-ui.card>
        </div>

        <x-ui.card>
            <span class="ls-kicker">Organizer Flow</span>
            <p class="mt-4 text-2xl font-black text-white">Actions rapides</p>
            <div class="flex flex-wrap gap-3">
                <x-ui.button as="a" :href="route('tournaments.create')">Créer un tournoi</x-ui.button>
                <x-ui.button as="a" :href="route('tournaments.index')" variant="secondary">Voir les tournois</x-ui.button>
                <x-ui.button as="a" :href="$currentTournament ? route('tournaments.matches.index', $currentTournament) : route('tournaments.index')" variant="secondary">Voir les matchs</x-ui.button>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2">
                <x-ui.card>
                    <h3 class="text-lg font-black text-slate-100 mb-4">Dernières mises à jour</h3>
                    @if($recentUpdates->isEmpty())
                        <x-ui.empty-state title="Aucune mise à jour" description="Les activités récentes apparaîtront ici." />
                    @else
                        <div class="space-y-3">
                            @foreach($recentUpdates as $match)
                                @php
                                    $teamALogo = $logoUrl($match->participantA?->logo);
                                    $teamBLogo = $logoUrl($match->participantB?->logo);
                                    $hasScore = !is_null($match->score_a) && !is_null($match->score_b);
                                @endphp

                                <div class="ls-list-item">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-100 truncate">{{ $match->tournament?->title ?? 'Tournament' }}</p>

                                        <div class="mt-1 flex items-center gap-2 text-sm text-slate-300">
                                            @if($teamALogo)
                                                <img src="{{ $teamALogo }}" alt="{{ $match->participantA?->name }}" class="h-6 w-6 rounded-full object-cover border border-slate-700">
                                            @else
                                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-700 text-[10px] font-bold text-slate-200">
                                                    {{ strtoupper(substr($match->participantA?->name ?? 'A', 0, 1)) }}
                                                </span>
                                            @endif

                                            <span class="truncate">{{ $match->participantA?->name ?? '-' }}</span>
                                            <span class="text-slate-500">vs</span>
                                            <span class="truncate">{{ $match->participantB?->name ?? '-' }}</span>

                                            @if($teamBLogo)
                                                <img src="{{ $teamBLogo }}" alt="{{ $match->participantB?->name }}" class="h-6 w-6 rounded-full object-cover border border-slate-700">
                                            @else
                                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-700 text-[10px] font-bold text-slate-200">
                                                    {{ strtoupper(substr($match->participantB?->name ?? 'B', 0, 1)) }}
                                                </span>
                                            @endif

                                            <span class="ls-separator-dot"></span>
                                            <span class="font-semibold text-emerald-300">
                                                {{ $hasScore ? ($match->score_a.' - '.$match->score_b) : 'No score' }}
                                            </span>
                                        </div>
                                    </div>

                                    <x-ui.badge :status="$match->status">{{ strtoupper(str_replace('_', ' ', $match->status)) }}</x-ui.badge>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-ui.card>
            </div>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-100 mb-4">Derniers tournois</h3>
                @if($recentTournaments->isEmpty())
                    <x-ui.empty-state title="Aucun tournoi" description="Créez votre premier tournoi." />
                @else
                    <div class="space-y-3">
                        @foreach($recentTournaments as $tournament)
                            <div class="ls-list-item">
                                <div>
                                    <p class="font-semibold text-slate-100">{{ $tournament->title }}</p>
                                    <p class="text-sm text-slate-400">{{ $tournament->sport?->name ?? 'Sport' }}</p>
                                </div>
                                <x-ui.badge>{{ $tournament->status }}</x-ui.badge>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
