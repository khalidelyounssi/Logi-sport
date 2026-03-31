<x-app-layout>
    <x-slot name="title">Match Details</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }}</x-slot>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Participant A</h3>
                <p class="text-xl font-semibold">{{ $match->participantA?->name }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Participant B</h3>
                <p class="text-xl font-semibold">{{ $match->participantB?->name }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Score</h3>
                <p>{{ $match->score_a ?? '-' }} - {{ $match->score_b ?? '-' }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Status</h3>
                <p>{{ $match->status }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Date</h3>
                <p>{{ $match->match_date?->format('Y-m-d H:i') ?? 'Not set' }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Location</h3>
                <p>{{ $match->location ?? 'Not set' }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Referee</h3>
                <p>{{ $match->referee?->name ?? 'Not assigned' }}</p>
            </div>
        </div>

        <div class="pt-4">
            <a href="{{ route('tournaments.matches.edit', [$tournament, $match]) }}" class="inline-flex px-5 py-3 rounded-2xl bg-blue-600 text-white font-semibold">
                Edit Match
            </a>
        </div>
    </div>
</x-app-layout>