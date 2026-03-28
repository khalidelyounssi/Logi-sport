<x-app-layout>
    <x-slot name="title">{{ $tournament->title }}</x-slot>
    <x-slot name="subtitle">Tournament details.</x-slot>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 space-y-4">
        <div>
            <h3 class="text-sm text-slate-400 uppercase tracking-wider">Title</h3>
            <p class="text-xl font-semibold">{{ $tournament->title }}</p>
        </div>

        <div>
            <h3 class="text-sm text-slate-400 uppercase tracking-wider">Description</h3>
            <p>{{ $tournament->description ?: 'No description' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Sport</h3>
                <p>{{ $tournament->sport?->name }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Type</h3>
                <p>{{ $tournament->type }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Status</h3>
                <p>{{ $tournament->status }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">Start Date</h3>
                <p>{{ $tournament->start_date?->format('Y-m-d') }}</p>
            </div>

            <div>
                <h3 class="text-sm text-slate-400 uppercase tracking-wider">End Date</h3>
                <p>{{ $tournament->end_date?->format('Y-m-d') ?? 'Not set' }}</p>
            </div>
        </div>

        <div class="pt-4">
            <a href="{{ route('tournaments.edit', $tournament) }}" class="inline-flex px-5 py-3 rounded-2xl bg-blue-600 text-white font-semibold">
                Edit Tournament
            </a>
        </div>
    </div>
</x-app-layout>