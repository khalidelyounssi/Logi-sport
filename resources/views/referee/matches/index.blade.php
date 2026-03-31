<x-app-layout>
    <x-slot name="title">My Assigned Matches</x-slot>
    <x-slot name="subtitle">View and update the scores of your assigned matches.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="text-xs uppercase text-slate-400 tracking-[0.2em]">
                    <tr>
                        <th class="p-6">Tournament</th>
                        <th class="p-6">Participant A</th>
                        <th class="p-6">Participant B</th>
                        <th class="p-6">Date</th>
                        <th class="p-6">Score</th>
                        <th class="p-6">Status</th>
                        <th class="p-6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matches as $match)
                        <tr class="border-t border-slate-100">
                            <td class="p-6 font-semibold">{{ $match->tournament?->title }}</td>
                            <td class="p-6">{{ $match->participantA?->name }}</td>
                            <td class="p-6">{{ $match->participantB?->name }}</td>
                            <td class="p-6">{{ $match->match_date?->format('Y-m-d H:i') ?? '-' }}</td>
                            <td class="p-6">{{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}</td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $match->status === 'finished' ? 'bg-green-50 text-green-600' : '' }}
                                    {{ $match->status === 'in_progress' ? 'bg-orange-50 text-orange-600' : '' }}
                                    {{ $match->status === 'scheduled' ? 'bg-blue-50 text-blue-600' : '' }}">
                                    {{ $match->status }}
                                </span>
                            </td>
                            <td class="p-6">
                                <a href="{{ route('referee.matches.edit', $match) }}"
                                   class="px-4 py-2 rounded-xl bg-blue-50 text-blue-600 text-sm font-semibold">
                                    Update Score
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-500">
                                No assigned matches found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>