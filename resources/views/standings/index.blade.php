<x-app-layout>
    <x-slot name="title">Standings</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} rankings and performance.</x-slot>

    <div class="space-y-8">
        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-5 py-4 rounded-2xl border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-3">Tournament</p>
                <h3 class="text-2xl font-black">{{ $tournament->title }}</h3>
            </div>

            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-3">Sport</p>
                <h3 class="text-2xl font-black">{{ $tournament->sport?->name }}</h3>
            </div>

            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-3">Participants</p>
                <h3 class="text-2xl font-black">{{ $standings->count() }}</h3>
            </div>
        </div>

        @if(in_array(auth()->user()->role, ['organizer', 'admin']))
            <div class="flex justify-end">
                <form action="{{ route('tournaments.standings.recalculate', $tournament) }}" method="POST">
                    @csrf
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
                        Recalculate Standings
                    </button>
                </form>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="text-xs uppercase text-slate-400 tracking-[0.2em] bg-slate-50">
                    <tr>
                        <th class="p-6">Rank</th>
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
                            <td class="p-6">
                                <span class="inline-flex w-10 h-10 items-center justify-center rounded-full 
                                    {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="p-6 font-semibold">{{ $standing->participant?->name }}</td>
                            <td class="p-6 font-bold text-blue-600">{{ $standing->points }}</td>
                            <td class="p-6">{{ $standing->played }}</td>
                            <td class="p-6 text-green-600 font-semibold">{{ $standing->won }}</td>
                            <td class="p-6 text-orange-500 font-semibold">{{ $standing->draw }}</td>
                            <td class="p-6 text-red-500 font-semibold">{{ $standing->lost }}</td>
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