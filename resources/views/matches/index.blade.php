<x-app-layout>
    <x-slot name="title">Matches</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} matches list.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-2xl border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            @if(auth()->user()->role === 'organizer')
                <a href="{{ route('tournaments.matches.create', $tournament) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold shadow-sm">
                    + Create Match
                </a>
            @else
                <div></div>
            @endif

            <a href="{{ route('tournaments.standings.index', $tournament) }}"
               class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-2xl font-semibold shadow-sm">
                View Standings
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs uppercase text-slate-400 tracking-[0.2em] bg-slate-50">
                        <tr>
                            <th class="p-6">Participant A</th>
                            <th class="p-6">Participant B</th>
                            <th class="p-6">Date</th>
                            <th class="p-6">Score</th>
                            <th class="p-6">Status</th>
                            <th class="p-6">Referee</th>
                            <th class="p-6">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($matches as $match)
                            <tr class="border-t border-slate-100">
                                <td class="p-6 font-semibold">{{ $match->participantA?->name }}</td>
                                <td class="p-6 font-semibold">{{ $match->participantB?->name }}</td>
                                <td class="p-6">{{ $match->match_date?->format('Y-m-d H:i') ?? '-' }}</td>
                                <td class="p-6">{{ $match->score_a ?? '-' }} - {{ $match->score_b ?? '-' }}</td>
                                <td class="p-6">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        {{ $match->status === 'finished' ? 'bg-green-50 text-green-600' : '' }}
                                        {{ $match->status === 'in_progress' ? 'bg-orange-50 text-orange-600' : '' }}
                                        {{ $match->status === 'scheduled' ? 'bg-blue-50 text-blue-600' : '' }}">
                                        {{ $match->status }}
                                    </span>
                                </td>
                                <td class="p-6">{{ $match->referee?->name ?? 'Not assigned' }}</td>
                                <td class="p-6">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('tournaments.matches.show', [$tournament, $match]) }}"
                                           class="px-3 py-2 rounded-xl bg-slate-100 text-sm">
                                            View
                                        </a>

                                        <a href="{{ route('tournaments.matches.edit', [$tournament, $match]) }}"
                                           class="px-3 py-2 rounded-xl bg-blue-50 text-blue-600 text-sm">
                                            Edit
                                        </a>

                                        @if(auth()->user()->role === 'organizer')
                                            <form action="{{ route('tournaments.matches.destroy', [$tournament, $match]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this match?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-2 rounded-xl bg-red-50 text-red-500 text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
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
        </div>
    </div>
</x-app-layout>