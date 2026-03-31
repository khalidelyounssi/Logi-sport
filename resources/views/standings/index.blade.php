<x-app-layout>
    <x-slot name="title">Standings</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} classement.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if(in_array(auth()->user()->role, ['organizer', 'admin']))
            <div class="flex justify-end">
                <form action="{{ route('tournaments.standings.recalculate', $tournament) }}" method="POST">
                    @csrf
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold">
                        Recalculate Standings
                    </button>
                </form>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="text-xs uppercase text-slate-400 tracking-[0.2em]">
                    <tr>
                        <th class="p-6">#</th>
                        <th class="p-6">Participant</th>
                        <th class="p-6">Points</th>
                        <th class="p-6">Played</th>
                        <th class="p-6">Won</th>
                        <th class="p-6">Draw</th>
                        <th class="p-6">Lost</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($standings as $index => $standing)
                        <tr class="border-t border-slate-100">
                            <td class="p-6 font-semibold">{{ $index + 1 }}</td>
                            <td class="p-6 font-semibold">{{ $standing->participant?->name }}</td>
                            <td class="p-6">{{ $standing->points }}</td>
                            <td class="p-6">{{ $standing->played }}</td>
                            <td class="p-6">{{ $standing->won }}</td>
                            <td class="p-6">{{ $standing->draw }}</td>
                            <td class="p-6">{{ $standing->lost }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-500">
                                No standings available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>