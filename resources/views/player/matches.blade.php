<x-app-layout>
    <x-slot name="title">My Matches</x-slot>
    <x-slot name="subtitle">Review all your matches, results, and match details.</x-slot>

    <div class="space-y-6">
        <x-ui.card class="bg-gradient-to-r from-blue-700 to-indigo-700 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Player Matches</p>
                    <h2 class="mt-1 text-2xl font-black">My Match History</h2>
                    <p class="mt-1 text-sm text-blue-100">
                        Review your fixtures, scores, referees, and match status.
                    </p>
                </div>

                <x-ui.button as="a" :href="route('player.dashboard')" variant="secondary" size="lg">
                    📊 Back to Dashboard
                </x-ui.button>
            </div>
        </x-ui.card>

        <x-ui.card padding="p-0">
            <div class="border-b border-slate-100 px-6 py-5">
                <h3 class="text-lg font-black text-slate-900">All My Matches</h3>
                <p class="text-sm text-slate-500">All matches linked to your player account.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400">
                        <tr>
                            <th class="p-4">Tournament</th>
                            <th class="p-4">Match</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Location</th>
                            <th class="p-4">Score</th>
                            <th class="p-4">Result</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Referee</th>
                        </tr>
                    </thead>

                    <tbody>
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
                            @endphp

                            <tr class="border-t border-slate-100">
                                <td class="p-4 font-semibold text-slate-900">
                                    {{ $match->tournament?->title ?? '—' }}
                                </td>

                                <td class="p-4">
                                    <div class="font-semibold text-slate-800">
                                        {{ $match->participantA?->name }} vs {{ $match->participantB?->name }}
                                    </div>
                                </td>

                                <td class="p-4 text-slate-600">
                                    {{ $match->match_date?->format('Y-m-d H:i') ?? '—' }}
                                </td>

                                <td class="p-4 text-slate-600">
                                    {{ $match->location ?? '—' }}
                                </td>

                                <td class="p-4 font-bold text-blue-700">
                                    {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                </td>

                                <td class="p-4">
                                    <x-ui.badge variant="{{ $variant }}">
                                        {{ $result }}
                                    </x-ui.badge>
                                </td>

                                <td class="p-4">
                                    <x-ui.badge :status="$match->status">
                                        {{ str_replace('_', ' ', $match->status) }}
                                    </x-ui.badge>
                                </td>

                                <td class="p-4 text-slate-600">
                                    {{ $match->referee?->name ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-slate-500">
                                    No matches found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-ui.card>
    </div>
</x-app-layout>