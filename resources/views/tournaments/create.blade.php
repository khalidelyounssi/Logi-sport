<x-app-layout>
    <x-slot name="title">Create Tournament</x-slot>
    <x-slot name="subtitle">Step 1/4: define tournament settings before adding participants.</x-slot>

    <div class="space-y-6">
        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <x-ui.card class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white">
            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Tournament Flow</p>
            <h2 class="mt-1 text-2xl font-black">Create -> Participants -> Matches -> Standings</h2>
            <p class="mt-1 text-sm text-blue-100">Start by creating your tournament structure.</p>
        </x-ui.card>

        <x-ui.card>
            <form action="{{ route('tournaments.store') }}" method="POST">
                @include('tournaments._form', ['buttonText' => 'Create Tournament'])
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
