<x-app-layout>
    <x-slot name="title">Edit Tournament</x-slot>
    <x-slot name="subtitle">Update tournament configuration and lifecycle status.</x-slot>

    <div class="space-y-6">
        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <x-ui.card class="bg-gradient-to-r from-slate-900 to-blue-800 text-white">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Editing</p>
            <h2 class="mt-1 text-2xl font-black">{{ $tournament->title }}</h2>
            <p class="mt-1 text-sm text-slate-300">Adjust dates, status, and competition format as needed.</p>
        </x-ui.card>

        <x-ui.card>
            <form action="{{ route('tournaments.update', $tournament) }}" method="POST">
                @method('PUT')
                @include('tournaments._form', [
                    'buttonText' => 'Update Tournament',
                    'tournament' => $tournament
                ])
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
