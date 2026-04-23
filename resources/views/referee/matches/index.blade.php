<x-app-layout>
    <x-slot name="title">My Matches</x-slot>
    <x-slot name="subtitle">Matches assigned to you for score updates.</x-slot>

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
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <div class="ls-flow-banner ls-flow-banner-step-3">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="ls-flow-label">Referee Command</p>
                    <h2 class="ls-flow-title">Assigned Matches</h2>
                    <p class="ls-flow-copy">Review fixtures and submit official score updates.</p>
                </div>

                <div class="ls-flow-actions">
                    <a href="{{ route('referee.dashboard') }}" class="ls-flow-pill">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-500">Assigned matches: {{ $matches->count() }}</p>
            <x-ui.badge variant="info">Referee Panel</x-ui.badge>
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

                        <div class="shrink-0">
                            @if($hasScore)
                                <div class="ls-score-chip">
                                    <p class="ls-score-chip-label">Score</p>
                                    <p class="ls-score-chip-value">{{ $match->score_a }}:{{ $match->score_b }}</p>
                                    <p class="ls-score-chip-meta">{{ $match->match_date?->format('d M • H:i') ?? 'Date TBD' }}</p>
                                </div>
                            @elseif($match->status === 'finished')
                                <div class="ls-score-chip">
                                    <p class="ls-score-chip-label">Score</p>
                                    <p class="ls-score-chip-value">--:--</p>
                                    <p class="ls-score-chip-meta">No score</p>
                                </div>
                            @else
                                <div class="ls-score-chip">
                                    <p class="ls-score-chip-label">Score</p>
                                    <p class="ls-score-chip-value">--:--</p>
                                    <p class="ls-score-chip-meta">{{ $match->match_date?->format('d M • H:i') ?? 'Date TBD' }}</p>
                                </div>
                            @endif
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
                        <p class="text-slate-400">{{ $match->tournament?->title ?? 'Tournament' }}</p>
                        <div class="flex items-center gap-2">
                            <x-ui.badge :status="$match->status">{{ str_replace('_', ' ', $match->status) }}</x-ui.badge>
                            <x-ui.button as="a" :href="route('referee.matches.edit', $match)" variant="primary" size="sm">Update Score</x-ui.button>
                        </div>
                    </div>
                </div>
            @empty
                <x-ui.empty-state title="No assigned matches found" description="You will see matches here once an organizer assigns them." />
            @endforelse
        </x-ui.card>
    </div>
</x-app-layout>
