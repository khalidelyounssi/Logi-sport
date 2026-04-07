<x-app-layout>
    <x-slot name="title">Edit Match</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} • update scheduling, referee, and scores.</x-slot>

    <div class="space-y-6">
        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <x-ui.card class="bg-gradient-to-r from-slate-900 to-blue-800 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Step 3/4</p>
                    <h2 class="mt-1 text-2xl font-black">Match Update</h2>
                    <p class="mt-1 text-sm text-slate-300">Keep fixture data, referee assignment, and scores accurate.</p>
                </div>

                <x-ui.button as="a" :href="route('tournaments.matches.index', $tournament)" variant="secondary" size="sm">
                    Back to Matches
                </x-ui.button>
            </div>
        </x-ui.card>

        <x-ui.card>
            <form action="{{ route('tournaments.matches.update', [$tournament, $match]) }}" method="POST">
                @method('PUT')
                @include('matches._form', [
                    'buttonText' => 'Update Match',
                    'match' => $match
                ])
            </form>
        </x-ui.card>
    </div>
</x-app-layout>