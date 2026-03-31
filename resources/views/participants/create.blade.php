<x-app-layout>
    <x-slot name="title">Add Participant</x-slot>

    <form method="POST" action="{{ route('tournaments.participants.store', $tournament) }}">
        @csrf

        <input type="text" name="name" placeholder="Name" class="border p-2 rounded">

        <select name="type" class="border p-2 rounded">
            <option value="team">Team</option>
            <option value="player">Player</option>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</x-app-layout>