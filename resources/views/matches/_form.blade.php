@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Participant A</label>
        <select name="participant_a_id" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            @foreach($participants as $participant)
                <option value="{{ $participant->id }}" {{ old('participant_a_id', $match->participant_a_id ?? '') == $participant->id ? 'selected' : '' }}>
                    {{ $participant->name }}
                </option>
            @endforeach
        </select>
        @error('participant_a_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Participant B</label>
        <select name="participant_b_id" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            @foreach($participants as $participant)
                <option value="{{ $participant->id }}" {{ old('participant_b_id', $match->participant_b_id ?? '') == $participant->id ? 'selected' : '' }}>
                    {{ $participant->name }}
                </option>
            @endforeach
        </select>
        @error('participant_b_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Match Date</label>
        <input type="datetime-local" name="match_date"
            value="{{ old('match_date', isset($match) && $match->match_date ? $match->match_date->format('Y-m-d\TH:i') : '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
        @error('match_date')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Location</label>
        <input type="text" name="location" value="{{ old('location', $match->location ?? '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
        @error('location')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    @if(auth()->user()->role === 'organizer')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Referee</label>
            <select name="referee_id" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                <option value="">No referee</option>
                @foreach($referees as $referee)
                    <option value="{{ $referee->id }}" {{ old('referee_id', $match->referee_id ?? '') == $referee->id ? 'selected' : '' }}>
                        {{ $referee->name }}
                    </option>
                @endforeach
            </select>
            @error('referee_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            <option value="scheduled" {{ old('status', $match->status ?? '') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="in_progress" {{ old('status', $match->status ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="finished" {{ old('status', $match->status ?? '') === 'finished' ? 'selected' : '' }}>Finished</option>
        </select>
        @error('status')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Score A</label>
        <input type="number" min="0" name="score_a" value="{{ old('score_a', $match->score_a ?? '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
        @error('score_a')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Score B</label>
        <input type="number" min="0" name="score_b" value="{{ old('score_b', $match->score_b ?? '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
        @error('score_b')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex items-center gap-4">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold">
        {{ $buttonText }}
    </button>

    <a href="{{ route('tournaments.matches.index', $tournament) }}" class="px-6 py-3 rounded-2xl border border-slate-300 text-slate-600">
        Cancel
    </a>
</div>