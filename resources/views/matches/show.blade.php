<x-app-layout>
    <x-slot name="title">Match Details</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} • fixture overview and official status.</x-slot>

    <div class="space-y-6">
        <div class="ls-flow-banner ls-flow-banner-step-3">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="ls-flow-label">Match Card</p>
                    <h2 class="ls-flow-title">{{ $match->participantA?->name ?? '-' }} vs {{ $match->participantB?->name ?? '-' }}</h2>
                </div>
                <x-ui.badge :status="$match->status">
                    {{ str_replace('_', ' ', $match->status) }}
                </x-ui.badge>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <x-ui.card class="lg:col-span-2">
                <h3 class="text-lg font-black text-white">Match Information</h3>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="ls-panel-soft px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Participant A</dt>
                        <dd class="mt-1 font-semibold text-slate-200">{{ $match->participantA?->name ?? '-' }}</dd>
                    </div>
                    <div class="ls-panel-soft px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Participant B</dt>
                        <dd class="mt-1 font-semibold text-slate-200">{{ $match->participantB?->name ?? '-' }}</dd>
                    </div>
                    <div class="ls-panel-soft px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Score</dt>
                        <dd class="mt-3">
                            <div class="ls-score-chip">
                                <p class="ls-score-chip-label">Score</p>
                                <p class="ls-score-chip-value">{{ $match->score_a ?? '-' }}:{{ $match->score_b ?? '-' }}</p>
                                <p class="ls-score-chip-meta">{{ $match->match_date?->format('Y-m-d H:i') ?? 'Not set' }}</p>
                            </div>
                        </dd>
                    </div>
                    <div class="ls-panel-soft px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Date</dt>
                        <dd class="mt-1 font-semibold text-slate-200">{{ $match->match_date?->format('Y-m-d H:i') ?? 'Not set' }}</dd>
                    </div>
                    <div class="ls-panel-soft px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Location</dt>
                        <dd class="mt-1 font-semibold text-slate-200">{{ $match->location ?? 'Not set' }}</dd>
                    </div>
                    <div class="ls-panel-soft px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Referee</dt>
                        <dd class="mt-1 font-semibold text-slate-200">{{ $match->referee?->name ?? 'Not assigned' }}</dd>
                    </div>
                </dl>
            </x-ui.card>

            <x-ui.card>
                <h3 class="text-lg font-black text-white">Actions</h3>
                <div class="mt-4 space-y-2">
                    <x-ui.button as="a" :href="route('tournaments.matches.edit', [$tournament, $match])" variant="primary" class="w-full justify-start">
                        Edit Match
                    </x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.matches.index', $tournament)" variant="secondary" class="w-full justify-start">
                        Back to Matches
                    </x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.standings.index', $tournament)" variant="secondary" class="w-full justify-start">
                        View Standings
                    </x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
