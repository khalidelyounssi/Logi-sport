<x-app-layout>
    <x-slot name="title">My Matches</x-slot>
    <x-slot name="subtitle">Review all your matches, results, and match details.</x-slot>

    <div class="space-y-6">
        <x-ui.card>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400">
                        <tr>
                            <th class="p-4">Tournament</th>
                            <th class="p-4">Match</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Location</th>
                            <th class="p-4">Score</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Referee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($matches as $match)
                            <tr class="border-t border-slate-100">
                                <td class="p-4 font-semibold">{{ $match->tournament?->title }}</td>
                                <td class="p-4">
                                    {{ $match->participantA?->name }} vs {{ $match->participantB?->name }}
                                </td>
                                <td class="p-4">{{ $match->match_date?->format('Y-m-d H:i') ?? '—' }}</td>
                                <td class="p-4">{{ $match->location ?? '—' }}</td>
                                <td class="p-4">
                                    {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                </td>
                                <td class="p-4">
                                    <x-ui.badge :status="$match->status">
                                        {{ str_replace('_', ' ', $match->status) }}
                                    </x-ui.badge>
                                </td>
                                <td class="p-4">{{ $match->referee?->name ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-slate-500">
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