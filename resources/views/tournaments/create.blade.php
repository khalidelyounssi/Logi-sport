<x-app-layout>
    <x-slot name="title">Create Tournament</x-slot>
    <x-slot name="subtitle">Add a new tournament to your platform.</x-slot>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
        <form action="{{ route('tournaments.store') }}" method="POST">
            @include('tournaments._form', ['buttonText' => 'Create Tournament'])
        </form>
    </div>
</x-app-layout>