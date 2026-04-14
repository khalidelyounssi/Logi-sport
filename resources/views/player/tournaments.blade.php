<x-app-layout>
    <x-slot name="title">My Tournaments</x-slot>
    <x-slot name="subtitle">See all tournaments where you are registered as a participant.</x-slot>

    <div class="space-y-6">
        <x-ui.card class="bg-gradient-to-r from-blue-700 to-indigo-700 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Player Tournaments</p>
                    <h2 class="mt-1 text-2xl font-black">My Tournament List</h2>
                    <p class="mt-1 text-sm text-blue-100">
                        Access all tournaments linked to your player account and follow their standings.
                    </p>
                </div>

                <x-ui.button as="a" :href="route('player.dashboard')" variant="secondary" size="lg">
                    📊 Back to Dashboard
                </x-ui.button>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse($tournaments as $tournament)
                <x-ui.card>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tournament</p>
                    <h3 class="mt-2 text-xl font-black text-slate-900">{{ $tournament->title }}</h3>
                    <p class="mt-2 text-sm text-slate-500">{{ $tournament->sport?->name ?? 'No sport' }}</p>

                    <div class="mt-4 flex items-center justify-between">
                        <x-ui.badge variant="info">
                            {{ $tournament->status }}
                        </x-ui.badge>

                        <a href="{{ route('tournaments.standings.index', $tournament) }}"
                           class="text-sm font-semibold text-blue-600 hover:underline">
                            View Standings
                        </a>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card>
                    <p class="text-slate-500">You are not linked to any tournament yet.</p>
                </x-ui.card>
            @endforelse
        </div>
    </div>
</x-app-layout>