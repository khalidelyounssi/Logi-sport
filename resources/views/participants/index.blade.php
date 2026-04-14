<x-app-layout>
    <x-slot name="title">Participants</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} roster and registration list.</x-slot>

    @php
        $availableTournaments = $availableTournaments ?? collect();
    @endphp

    <div class="space-y-6">
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        @if($availableTournaments->isNotEmpty())
            <x-ui.card>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tournament Selector</p>
                        <p class="mt-1 text-sm text-slate-300">Choisissez le tournoi pour voir ses participants.</p>
                    </div>

                    <div class="w-full sm:w-auto">
                        <label for="participants_tournament_switcher" class="sr-only">Select tournament</label>
                        <select
                            id="participants_tournament_switcher"
                            class="ui-select min-w-[280px]"
                            onchange="if (this.value) window.location.href = this.value"
                        >
                            @foreach($availableTournaments as $item)
                                <option
                                    value="{{ route('tournaments.participants.index', $item) }}"
                                    @selected($item->id === $tournament->id)
                                >
                                    {{ $item->title }}{{ $item->sport?->name ? ' • '.$item->sport->name : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-ui.card>
        @endif

        <x-ui.card class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Tournament Flow</p>
                    <h2 class="mt-1 text-2xl font-black">{{ $tournament->title }}</h2>
                    <p class="mt-1 text-sm text-blue-100">Step 2/4: Manage participants, then generate matches.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-ui.button as="a" :href="route('tournaments.show', $tournament)" variant="secondary" size="sm">Overview</x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.matches.index', $tournament)" variant="secondary" size="sm">Matches</x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.standings.index', $tournament)" variant="secondary" size="sm">Standings</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-500">{{ $participants->count() }} participants registered</p>

            <x-ui.button as="a" :href="route('tournaments.participants.create', $tournament)" variant="primary" size="lg">
                <span>➕</span>
                <span>Add Participant</span>
            </x-ui.button>
        </div>

        <x-ui.card padding="p-0">
            <x-ui.table>
                <thead class="bg-slate-50 text-xs uppercase tracking-[0.18em] text-slate-400">
                    <tr>
                        <th class="p-5">Name</th>
                        <th class="p-5">Type</th>
                        <th class="p-5">Status</th>
                        <th class="p-5">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($participants as $participant)
                        <tr class="border-t border-slate-100">
                            <td class="p-5 font-semibold text-slate-900">{{ $participant->name }}</td>

                            <td class="p-5">
                                <x-ui.badge variant="info">
                                    {{ $participant->type ?? 'participant' }}
                                </x-ui.badge>
                            </td>

                            <td class="p-5">
                                <x-ui.badge :status="$participant->status ?? 'active'">
                                    {{ $participant->status ?? 'active' }}
                                </x-ui.badge>
                            </td>

                            <td class="p-5">
                                <div class="flex flex-wrap gap-2">
                                    <x-ui.button as="a" :href="route('tournaments.participants.edit', [$tournament, $participant])" variant="secondary" size="sm">
                                        Edit
                                    </x-ui.button>

                                    <form method="POST" action="{{ route('tournaments.participants.destroy', [$tournament, $participant]) }}" onsubmit="return confirm('Delete this participant?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button type="submit" variant="danger-soft" size="sm">
                                            Delete
                                        </x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center">
                                <p class="text-lg font-semibold text-slate-700">No participants added yet</p>
                                <p class="mt-1 text-sm text-slate-500">Add teams or players to continue to the match generation step.</p>
                                <x-ui.button as="a" :href="route('tournaments.participants.create', $tournament)" class="mt-4" variant="primary">
                                    Add First Participant
                                </x-ui.button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>
    </div>
</x-app-layout>
