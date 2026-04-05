<x-app-layout>
    <x-slot name="title">Create Match</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} • add a new fixture between participants.</x-slot>

    <div class="space-y-6">
        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <x-ui.card class="bg-gradient-to-r from-slate-900 to-blue-900 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Step 3/4</p>
                    <h2 class="mt-1 text-2xl font-black">Match Scheduling</h2>
                    <p class="mt-1 text-sm text-slate-300">Create a match manually or use automatic generation.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary" size="sm">Participants</x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.standings.index', $tournament)" variant="secondary" size="sm">Standings</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <form action="{{ route('tournaments.matches.store', $tournament) }}" method="POST">
                @include('matches._form', ['buttonText' => 'Create Match'])
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
