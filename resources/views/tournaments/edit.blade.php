<x-app-layout>
    <x-slot name="title">Edit Tournament</x-slot>
    <x-slot name="subtitle">Update your tournament information.</x-slot>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
        <form action="{{ route('tournaments.update', $tournament) }}" method="POST">
            @method('PUT')
            @include('tournaments._form', [
                'buttonText' => 'Update Tournament',
                'tournament' => $tournament
            ])
        </form>
    </div>
</x-app-layout>