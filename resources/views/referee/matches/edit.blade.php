<x-app-layout>
    <x-slot name="title">Update Match Score</x-slot>
    <x-slot name="subtitle">Manage the score and status of this assigned match.</x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="text-center bg-slate-50 rounded-[2rem] p-8">
                    <h3 class="text-3xl font-black text-slate-900 mb-2">{{ $match->participantA?->name }}</h3>
                    <p class="text-slate-400 uppercase tracking-[0.2em] text-sm mb-6">Participant A</p>
                    <div class="text-6xl font-black text-blue-600">{{ $match->score_a ?? 0 }}</div>
                </div>

                <div class="text-center bg-slate-50 rounded-[2rem] p-8">
                    <h3 class="text-3xl font-black text-slate-900 mb-2">{{ $match->participantB?->name }}</h3>
                    <p class="text-slate-400 uppercase tracking-[0.2em] text-sm mb-6">Participant B</p>
                    <div class="text-6xl font-black text-blue-600">{{ $match->score_b ?? 0 }}</div>
                </div>
            </div>

            <form action="{{ route('referee.matches.update', $match) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Score A</label>
                        <input type="number" min="0" name="score_a" value="{{ old('score_a', $match->score_a ?? 0) }}"
                            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        @error('score_a')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Score B</label>
                        <input type="number" min="0" name="score_b" value="{{ old('score_b', $match->score_b ?? 0) }}"
                            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        @error('score_b')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        <option value="scheduled" {{ old('status', $match->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="in_progress" {{ old('status', $match->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="finished" {{ old('status', $match->status) === 'finished' ? 'selected' : '' }}>Finished</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold">
                        Save Score
                    </button>

                    <a href="{{ route('referee.matches.index') }}" class="px-6 py-3 rounded-2xl border border-slate-300 text-slate-600">
                        Back
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 space-y-5">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Tournament</p>
                <h3 class="text-xl font-bold">{{ $match->tournament?->title }}</h3>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Date</p>
                <p>{{ $match->match_date?->format('Y-m-d H:i') ?? 'Not scheduled' }}</p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Location</p>
                <p>{{ $match->location ?? 'No location' }}</p>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Assigned Referee</p>
                <p>{{ $match->referee?->name }}</p>
            </div>
        </div>
    </div>
</x-app-layout>