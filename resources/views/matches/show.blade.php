<x-app-layout>
    <x-slot name="title">Match Details</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} • fixture overview and official status.</x-slot>

    <div class="space-y-6">
        <x-ui.card class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Match Card</p>
                    <h2 class="mt-1 text-2xl font-black">{{ $match->participantA?->name ?? '-' }} vs {{ $match->participantB?->name ?? '-' }}</h2>
                </div>
                <x-ui.badge :status="$match->status">
                    {{ str_replace('_', ' ', $match->status) }}
                </x-ui.badge>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <x-ui.card class="lg:col-span-2">
                <h3 class="text-lg font-black text-slate-900">Match Information</h3>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Participant A</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $match->participantA?->name ?? '-' }}</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Participant B</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $match->participantB?->name ?? '-' }}</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Score</dt>
                        <dd class="mt-1 text-lg font-black text-blue-700">{{ $match->score_a ?? '-' }} - {{ $match->score_b ?? '-' }}</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Date</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $match->match_date?->format('Y-m-d H:i') ?? 'Not set' }}</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Location</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $match->location ?? 'Not set' }}</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Referee</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $match->referee?->name ?? 'Not assigned' }}</dd>
                    </div>
                </dl>
            </x-ui.card>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-900">Actions</h3>
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
