<x-app-layout>
    <x-slot name="title">Create Match</x-slot>
    <x-slot name="subtitle">Add a new match to this tournament.</x-slot>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
        <form action="{{ route('tournaments.matches.store', $tournament) }}" method="POST">
            @include('matches._form', ['buttonText' => 'Create Match'])
        </form>
    </div>
</x-app-layout>