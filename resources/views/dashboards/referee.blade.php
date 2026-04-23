<x-app-layout>
    <x-slot name="title">Referee Dashboard</x-slot>
    <x-slot name="subtitle">Suivi rapide des matchs assignés et résultats.</x-slot>

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
            <x-ui.card><p class="ls-stat-label">Assignés</p><p class="ls-stat-value text-emerald-300">{{ $assigned }}</p><p class="ls-stat-trend">Owned fixtures</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">En cours</p><p class="ls-stat-value text-amber-300">{{ $inProgress }}</p><p class="ls-stat-trend">Live now</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">Terminés</p><p class="ls-stat-value text-cyan-300">{{ $completed }}</p><p class="ls-stat-trend">Closed reports</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">En attente</p><p class="ls-stat-value">{{ $pending }}</p><p class="ls-stat-trend">Pending action</p></x-ui.card>
        </div>

        <x-ui.card>
            <div class="flex flex-wrap gap-3">
                <x-ui.button as="a" :href="route('referee.matches.index')">Mes matchs</x-ui.button>
            </div>
        </x-ui.card>

        <x-ui.card>
            <h3 class="text-lg font-black text-slate-100 mb-4">Matchs récents</h3>
            @if($recentMatches->isEmpty())
                <x-ui.empty-state title="Aucun match assigné" description="Les matchs apparaîtront ici automatiquement." />
            @else
                <div class="space-y-3">
                    @foreach($recentMatches as $match)
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

                                    <span class="truncate">{{ $match->participantA?->name ?? 'A' }}</span>
                                    <span class="text-slate-500">vs</span>
                                    <span class="truncate">{{ $match->participantB?->name ?? 'B' }}</span>

                                    @if($teamBLogo)
                                        <img src="{{ $teamBLogo }}" alt="{{ $match->participantB?->name }}" class="h-6 w-6 rounded-full object-cover border border-slate-700">
                                    @else
                                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-700 text-[10px] font-bold text-slate-200">
                                            {{ strtoupper(substr($match->participantB?->name ?? 'B', 0, 1)) }}
                                        </span>
                                    @endif

                                    <span class="ls-separator-dot"></span>
                                    <span class="font-semibold text-emerald-300">{{ $hasScore ? ($match->score_a.' - '.$match->score_b) : 'No score' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <x-ui.badge :status="$match->status">{{ strtoupper(str_replace('_', ' ', $match->status)) }}</x-ui.badge>
                                <x-ui.button as="a" :href="route('referee.matches.edit', $match)" size="sm">Saisir score</x-ui.button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-ui.card>
    </div>
</x-app-layout>
