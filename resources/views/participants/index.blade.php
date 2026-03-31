<x-app-layout>
    <x-slot name="title">Participants</x-slot>

    <div class="space-y-6">

        <div class="flex justify-between">
            <h2 class="text-xl font-bold">{{ $tournament->title }}</h2>

            <a href="{{ route('tournaments.participants.create', $tournament) }}"
               class="bg-blue-600 text-white px-5 py-3 rounded-2xl">
                + Add Participant
            </a>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $participant)
                        <tr>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->type }}</td>
                            <td class="flex gap-2">
                                <a href="{{ route('tournaments.participants.edit', [$tournament, $participant]) }}">Edit</a>

                                <form method="POST" action="{{ route('tournaments.participants.destroy', [$tournament, $participant]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>