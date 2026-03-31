<x-app-layout>
    <x-slot name="title">Edit Participant</x-slot>

    <form method="POST" action="{{ route('tournaments.participants.update', [$tournament, $participant]) }}">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $participant->name }}" class="border p-2 rounded">

        <select name="type" class="border p-2 rounded">
            <option value="team" {{ $participant->type === 'team' ? 'selected' : '' }}>Team</option>
            <option value="player" {{ $participant->type === 'player' ? 'selected' : '' }}>Player</option>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</x-app-layout>