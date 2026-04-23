@csrf

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div>
        <label class="ui-label">Participant A</label>
        <select name="participant_a_id" class="ui-select">
            <option value="">Select participant A</option>
            @foreach($participants as $participant)
                <option value="{{ $participant->id }}"
                    {{ old('participant_a_id', $match->participant_a_id ?? '') == $participant->id ? 'selected' : '' }}>
                    {{ $participant->name }}
                </option>
            @endforeach
        </select>
        @error('participant_a_id')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="ui-label">Participant B</label>
        <select name="participant_b_id" class="ui-select">
            <option value="">Select participant B</option>
            @foreach($participants as $participant)
                <option value="{{ $participant->id }}"
                    {{ old('participant_b_id', $match->participant_b_id ?? '') == $participant->id ? 'selected' : '' }}>
                    {{ $participant->name }}
                </option>
            @endforeach
        </select>
        @error('participant_b_id')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="ui-label">Match Date</label>
        <input
            type="datetime-local"
            name="match_date"
            value="{{ old('match_date', isset($match) && $match->match_date ? $match->match_date->format('Y-m-d\TH:i') : '') }}"
            class="ui-input"
        >
        @error('match_date')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="ui-label">Location</label>
        <input
            type="text"
            name="location"
            value="{{ old('location', $match->location ?? '') }}"
            placeholder="Stadium / Field / Court"
            class="ui-input"
        >
        @error('location')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="ui-label">Referee</label>
        <select name="referee_id" class="ui-select">
            <option value="">No referee assigned</option>
            @foreach($referees as $referee)
                <option value="{{ $referee->id }}"
                    {{ old('referee_id', $match->referee_id ?? '') == $referee->id ? 'selected' : '' }}>
                    {{ $referee->name }}
                </option>
            @endforeach
        </select>
        @error('referee_id')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="ui-label">Status</label>
        <select name="status" class="ui-select">
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
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="ui-label">Score A</label>
        <input
            type="number"
            min="0"
            name="score_a"
            value="{{ old('score_a', $match->score_a ?? '') }}"
            class="ui-input"
        >
        @error('score_a')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="ui-label">Score B</label>
        <input
            type="number"
            min="0"
            name="score_b"
            value="{{ old('score_b', $match->score_b ?? '') }}"
            class="ui-input"
        >
        @error('score_b')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex items-center gap-4">
    <button type="submit" class="rounded-2xl border border-emerald-300/20 bg-emerald-400 px-6 py-3 font-semibold text-slate-950 shadow-[0_18px_40px_rgba(53,224,161,0.25)] transition hover:bg-emerald-300">
        {{ $buttonText }}
    </button>

    <a href="{{ route('tournaments.matches.index', $tournament) }}"
       class="rounded-2xl border border-slate-700/80 bg-slate-900/80 px-6 py-3 text-slate-300 transition hover:bg-slate-800/90">
        Cancel
    </a>
</div>
