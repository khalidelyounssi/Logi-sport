<x-app-layout>
    <x-slot name="title">Tournaments</x-slot>
    <x-slot name="subtitle">Manage all your tournaments here.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end">
            <a href="{{ route('tournaments.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold">
                + Create Tournament
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="text-xs uppercase text-slate-400 tracking-[0.2em]">
                    <tr>
                        <th class="p-6">Title</th>
                        <th class="p-6">Sport</th>
                        <th class="p-6">Type</th>
                        <th class="p-6">Status</th>
                        <th class="p-6">Start Date</th>
                        <th class="p-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tournaments as $tournament)
                        <tr class="border-t border-slate-100">
                            <td class="p-6 font-semibold">{{ $tournament->title }}</td>
                            <td class="p-6">{{ $tournament->sport?->name }}</td>
                            <td class="p-6">{{ $tournament->type }}</td>
                            <td class="p-6">{{ $tournament->status }}</td>
                            <td class="p-6">{{ $tournament->start_date?->format('Y-m-d') }}</td>
                            <td class="p-6">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('tournaments.show', $tournament) }}" class="px-3 py-2 rounded-xl bg-slate-100 text-sm">View</a>
                                    <a href="{{ route('tournaments.edit', $tournament) }}" class="px-3 py-2 rounded-xl bg-blue-50 text-blue-600 text-sm">Edit</a>

                                    <form action="{{ route('tournaments.destroy', $tournament) }}" method="POST" onsubmit="return confirm('Delete this tournament?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-2 rounded-xl bg-red-50 text-red-500 text-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-500">No tournaments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $tournaments->links() }}
        </div>
    </div>
</x-app-layout>