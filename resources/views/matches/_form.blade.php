@csrf

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Participant A</label>
        <select name="participant_a_id" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select participant A</option>
            @foreach($participants as $participant)
                <option value="{{ $participant->id }}"
                    {{ old('participant_a_id', $match->participant_a_id ?? '') == $participant->id ? 'selected' : '' }}>
                    {{ $participant->name }}
                </option>
            @endforeach
        </select>
        @error('participant_a_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Participant B</label>
        <select name="participant_b_id" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select participant B</option>
            @foreach($participants as $participant)
                <option value="{{ $participant->id }}"
                    {{ old('participant_b_id', $match->participant_b_id ?? '') == $participant->id ? 'selected' : '' }}>
                    {{ $participant->name }}
                </option>
            @endforeach
        </select>
        @error('participant_b_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Match Date</label>
        <input
            type="datetime-local"
            name="match_date"
            value="{{ old('match_date', isset($match) && $match->match_date ? $match->match_date->format('Y-m-d\TH:i') : '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
        >
        @error('match_date')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Location</label>
        <input
            type="text"
            name="location"
            value="{{ old('location', $match->location ?? '') }}"
            placeholder="Stadium / Field / Court"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
        >
        @error('location')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Referee</label>
        <select name="referee_id" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            <option value="">No referee assigned</option>
            @foreach($referees as $referee)
                <option value="{{ $referee->id }}"
                    {{ old('referee_id', $match->referee_id ?? '') == $referee->id ? 'selected' : '' }}>
                    {{ $referee->name }}
                </option>
            @endforeach
        </select>
        @error('referee_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            <option value="scheduled" {{ old('status', $match->status ?? 'scheduled') === 'scheduled' ? 'selected' : '' }}>
                Scheduled
            </option>
            <option value="in_progress" {{ old('status', $match->status ?? '') === 'in_progress' ? 'selected' : '' }}>
                In Progress
            </option>
            <option value="finished" {{ old('status', $match->status ?? '') === 'finished' ? 'selected' : '' }}>
                Finished
            </option>
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Score A</label>
        <input
            type="number"
            min="0"
            name="score_a"
            value="{{ old('score_a', $match->score_a ?? '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
        >
        @error('score_a')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-700">Score B</label>
        <input
            type="number"
            min="0"
            name="score_b"
            value="{{ old('score_b', $match->score_b ?? '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
        >
        @error('score_b')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex items-center gap-4">
    <button type="submit" class="rounded-2xl bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700">
        {{ $buttonText }}
    </button>

    <a href="{{ route('tournaments.matches.index', $tournament) }}"
       class="rounded-2xl border border-slate-300 px-6 py-3 text-slate-600">
        Cancel
    </a>
</div>