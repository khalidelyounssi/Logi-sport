<x-app-layout>
    <x-slot name="title">Tournaments</x-slot>
    <x-slot name="subtitle">Create, track, and manage your competitions from one place.</x-slot>

    @php
        $currentPageTournaments = $tournaments->getCollection();
    @endphp

    <div class="space-y-6">
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">This Page</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $currentPageTournaments->count() }}</p>
                <p class="mt-1 text-sm text-slate-500">Visible tournaments</p>
            </x-ui.card>

            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Live</p>
                <p class="mt-2 text-2xl font-black text-amber-600">{{ $currentPageTournaments->where('status', 'live')->count() }}</p>
                <p class="mt-1 text-sm text-slate-500">Ongoing tournaments</p>
            </x-ui.card>

            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Completed</p>
                <p class="mt-2 text-2xl font-black text-emerald-600">{{ $currentPageTournaments->where('status', 'completed')->count() }}</p>
                <p class="mt-1 text-sm text-slate-500">Finished tournaments</p>
            </x-ui.card>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-500">Total: {{ $tournaments->total() }} tournaments</p>

            <x-ui.button as="a" :href="route('tournaments.create')" variant="primary" size="lg">
                <span>➕</span>
                <span>Create Tournament</span>
            </x-ui.button>
        </div>

        <x-ui.card padding="p-0">
            <x-ui.table class="rounded-2xl">
                <thead class="bg-slate-50 text-xs uppercase tracking-[0.18em] text-slate-400">
                    <tr>
                        <th class="p-5">Tournament</th>
                        <th class="p-5">Sport</th>
                        <th class="p-5">Type</th>
                        <th class="p-5">Status</th>
                        <th class="p-5">Start Date</th>
                        <th class="p-5">Flow</th>
                        <th class="p-5">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tournaments as $tournament)
                        <tr class="border-t border-slate-100 align-top">
                            <td class="p-5">
                                <p class="font-semibold text-slate-900">{{ $tournament->title }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($tournament->description ?: 'No description', 70) }}</p>
                            </td>

                            <td class="p-5">{{ $tournament->sport?->name ?? '-' }}</td>

                            <td class="p-5">
                                <x-ui.badge variant="info">
                                    {{ str_replace('_', ' ', $tournament->type) }}
                                </x-ui.badge>
                            </td>

                            <td class="p-5">
                                <x-ui.badge :status="$tournament->status">
                                    {{ str_replace('_', ' ', $tournament->status) }}
                                </x-ui.badge>
                            </td>

                            <td class="p-5">{{ $tournament->start_date?->format('Y-m-d') ?? '-' }}</td>

                            <td class="p-5">
                                <div class="flex flex-wrap gap-2">
                                    <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary" size="sm">Participants</x-ui.button>
                                    <x-ui.button as="a" :href="route('tournaments.matches.index', $tournament)" variant="secondary" size="sm">Matches</x-ui.button>
                                    <x-ui.button as="a" :href="route('tournaments.standings.index', $tournament)" variant="secondary" size="sm">Standings</x-ui.button>
                                </div>
                            </td>

                            <td class="p-5">
                                <div class="flex flex-wrap gap-2">
                                    <x-ui.button as="a" :href="route('tournaments.show', $tournament)" variant="dark" size="sm">Show</x-ui.button>
                                    <x-ui.button as="a" :href="route('tournaments.edit', $tournament)" variant="secondary" size="sm">Edit</x-ui.button>

                                    <form action="{{ route('tournaments.destroy', $tournament) }}" method="POST" onsubmit="return confirm('Delete this tournament?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button type="submit" variant="danger-soft" size="sm">Delete</x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center">
                                <p class="text-lg font-semibold text-slate-700">No tournaments yet</p>
                                <p class="mt-1 text-sm text-slate-500">Create your first tournament to start the organizer flow.</p>
                                <x-ui.button as="a" :href="route('tournaments.create')" class="mt-4" variant="primary">Create Tournament</x-ui.button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>

        <div>
            {{ $tournaments->links() }}
        </div>
    </div>
</x-app-layout>
