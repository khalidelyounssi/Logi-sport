<x-app-layout>
    <x-slot name="title">My Matches</x-slot>
    <x-slot name="subtitle">Matches assigned to you for score updates.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-500">Assigned matches: {{ $matches->count() }}</p>
            <x-ui.badge variant="info">Referee Panel</x-ui.badge>
        </div>

        <x-ui.card padding="p-0">
            <x-ui.table>
                <thead class="bg-slate-50 text-xs uppercase tracking-[0.18em] text-slate-400">
                    <tr>
                        <th class="p-5">Tournament</th>
                        <th class="p-5">Participant A</th>
                        <th class="p-5">Participant B</th>
                        <th class="p-5">Date</th>
                        <th class="p-5">Score</th>
                        <th class="p-5">Status</th>
                        <th class="p-5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matches as $match)
                        <tr class="border-t border-slate-100">
                            <td class="p-5 font-semibold text-slate-900">{{ $match->tournament?->title }}</td>
                            <td class="p-5">{{ $match->participantA?->name }}</td>
                            <td class="p-5">{{ $match->participantB?->name }}</td>
                            <td class="p-5">{{ $match->match_date?->format('Y-m-d H:i') ?? '-' }}</td>
                            <td class="p-5">{{ $match->score_a ?? '-' }} - {{ $match->score_b ?? '-' }}</td>
                            <td class="p-5">
                                <x-ui.badge :status="$match->status">
                                    {{ str_replace('_', ' ', $match->status) }}
                                </x-ui.badge>
                            </td>
                            <td class="p-5">
                                <x-ui.button as="a" :href="route('referee.matches.edit', $match)" variant="primary" size="sm">
                                    Update Score
                                </x-ui.button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center">
                                <p class="text-lg font-semibold text-slate-700">No assigned matches found</p>
                                <p class="mt-1 text-sm text-slate-500">You will see matches here once an organizer assigns them.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>
    </div>
</x-app-layout>
