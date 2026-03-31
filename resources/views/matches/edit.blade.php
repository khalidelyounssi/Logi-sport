<x-app-layout>
    <x-slot name="title">Edit Match</x-slot>
    <x-slot name="subtitle">Update match information and score.</x-slot>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
        <form action="{{ route('tournaments.matches.update', [$tournament, $match]) }}" method="POST">
            @method('PUT')
            @include('matches._form', [
                'buttonText' => 'Update Match',
                'match' => $match
            ])
        </form>
    </div>
</x-app-layout>