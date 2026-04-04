<x-app-layout>
    <x-slot name="title">Update Match Score</x-slot>
    <x-slot name="subtitle">Manage the score and status of this assigned match.</x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
            <form action="{{ route('referee.matches.update', $match) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- hidden inputs اللي غادي يتبدلو بالـ JS --}}
                <input type="hidden" name="score_a" id="score_a" value="{{ old('score_a', $match->score_a ?? 0) }}">
                <input type="hidden" name="score_b" id="score_b" value="{{ old('score_b', $match->score_b ?? 0) }}">

                <div class="bg-[#eef2ff] rounded-[2rem] p-8 border border-slate-100">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4 text-lg">
                            <span class="text-orange-600 font-bold">● {{ strtoupper(str_replace('_', ' ', $match->status)) }}</span>
                            <span class="text-slate-500">{{ $match->match_date?->format('Y-m-d H:i') ?? 'No date' }}</span>
                        </div>

                        <div class="px-4 py-2 rounded-full bg-orange-50 text-orange-600 font-semibold text-sm">
                            {{ $match->location ?? 'No location' }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        {{-- Participant A --}}
                        <div class="bg-white rounded-[2rem] p-8 text-center shadow-sm">
                            <h3 class="text-4xl font-black mb-3">{{ $match->participantA?->name }}</h3>
                            <p class="text-slate-400 uppercase tracking-[0.2em] text-sm mb-8">Participant A</p>

                            <div class="flex items-center justify-center gap-8">
                                <button type="button" onclick="decreaseScore('score_a', 'score_a_display')" class="w-16 h-16 rounded-full border border-blue-200 text-3xl text-blue-600">
                                    −
                                </button>

                                <span id="score_a_display" class="text-8xl font-black text-blue-600">
                                    {{ old('score_a', $match->score_a ?? 0) }}
                                </span>

                                <button type="button" onclick="increaseScore('score_a', 'score_a_display')" class="w-16 h-16 rounded-full bg-blue-600 text-white text-3xl shadow-lg">
                                    +
                                </button>
                            </div>

                            @error('score_a')
                                <p class="text-red-500 text-sm mt-4">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Participant B --}}
                        <div class="bg-white rounded-[2rem] p-8 text-center shadow-sm">
                            <h3 class="text-4xl font-black mb-3">{{ $match->participantB?->name }}</h3>
                            <p class="text-slate-400 uppercase tracking-[0.2em] text-sm mb-8">Participant B</p>

                            <div class="flex items-center justify-center gap-8">
                                <button type="button" onclick="decreaseScore('score_b', 'score_b_display')" class="w-16 h-16 rounded-full border border-blue-200 text-3xl text-blue-600">
                                    −
                                </button>

                                <span id="score_b_display" class="text-8xl font-black text-slate-900">
                                    {{ old('score_b', $match->score_b ?? 0) }}
                                </span>

                                <button type="button" onclick="increaseScore('score_b', 'score_b_display')" class="w-16 h-16 rounded-full bg-blue-600 text-white text-3xl shadow-lg">
                                    +
                                </button>
                            </div>

                            @error('score_b')
                                <p class="text-red-500 text-sm mt-4">{{ $message }}</p>
                            @enderror
                        </div>
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

    <script>
        function increaseScore(inputId, displayId) {
            const input = document.getElementById(inputId);
            const display = document.getElementById(displayId);

            let value = parseInt(input.value) || 0;
            value++;
            input.value = value;
            display.textContent = value;
        }

        function decreaseScore(inputId, displayId) {
            const input = document.getElementById(inputId);
            const display = document.getElementById(displayId);

            let value = parseInt(input.value) || 0;
            if (value > 0) {
                value--;
            }

            input.value = value;
            display.textContent = value;
        }
    </script>
</x-app-layout>