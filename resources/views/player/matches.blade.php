<x-app-layout>
    <x-slot name="title">My Matches</x-slot>
    <x-slot name="subtitle">Review all your matches, results, and match details.</x-slot>

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
        <div class="ls-flow-banner ls-flow-banner-step-3">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="ls-flow-label">Player Matches</p>
                    <h2 class="ls-flow-title">My Match History</h2>
                    <p class="ls-flow-copy">
                        Review your fixtures, scores, referees, and match status.
                    </p>
                </div>

                <a href="{{ route('player.dashboard') }}" class="ls-flow-pill">Back to Dashboard</a>
            </div>
        </div>

        <x-ui.card>
            <h3 class="text-lg font-black text-slate-100 mb-4">All My Matches</h3>

            @forelse($matches as $match)
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
                        <p class="flex items-center gap-2 text-slate-400">
                            <span>{{ $match->tournament?->title ?? 'Tournament' }}</span>
                            <span class="ls-separator-dot"></span>
                            <span>{{ $match->location ?? 'No location' }}</span>
                        </p>
                        <div class="flex items-center gap-2">
                            <x-ui.badge variant="{{ $variant }}">{{ $result }}</x-ui.badge>
                            <x-ui.badge :status="$match->status">{{ str_replace('_', ' ', $match->status) }}</x-ui.badge>
                        </div>
                    </div>
                </div>
            @empty
                <x-ui.empty-state title="No matches found" description="Your match cards will appear here." />
            @endforelse
        </x-ui.card>
    </div>
</x-app-layout>
