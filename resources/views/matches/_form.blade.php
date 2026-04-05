@csrf

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <label for="participant_a_id" class="ui-label">Participant A</label>
        <select id="participant_a_id" name="participant_a_id" class="ui-select" required>
            @foreach($participants as $participant)
                <option value="{{ $participant->id }}" {{ old('participant_a_id', $match->participant_a_id ?? '') == $participant->id ? 'selected' : '' }}>
                    {{ $participant->name }}
                </option>
            @endforeach
        </select>
        @error('participant_a_id')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="participant_b_id" class="ui-label">Participant B</label>
        <select id="participant_b_id" name="participant_b_id" class="ui-select" required>
            @foreach($participants as $participant)
                <option value="{{ $participant->id }}" {{ old('participant_b_id', $match->participant_b_id ?? '') == $participant->id ? 'selected' : '' }}>
                    {{ $participant->name }}
                </option>
            @endforeach
        </select>
        @error('participant_b_id')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="match_date" class="ui-label">Match Date</label>
        <input id="match_date" type="datetime-local" name="match_date" value="{{ old('match_date', isset($match) && $match->match_date ? $match->match_date->format('Y-m-d\TH:i') : '') }}" class="ui-input">
        @error('match_date')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="location" class="ui-label">Location</label>
        <input id="location" type="text" name="location" value="{{ old('location', $match->location ?? '') }}" class="ui-input" placeholder="Stadium / Court">
        @error('location')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    @if(auth()->user()->role === 'organizer')
        <div>
            <label for="referee_id" class="ui-label">Referee</label>
            <select id="referee_id" name="referee_id" class="ui-select">
                <option value="">No referee</option>
                @foreach($referees as $referee)
                    <option value="{{ $referee->id }}" {{ old('referee_id', $match->referee_id ?? '') == $referee->id ? 'selected' : '' }}>
                        {{ $referee->name }}
                    </option>
                @endforeach
            </select>
            @error('referee_id')
                <p class="ui-field-error">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div>
        <label for="status" class="ui-label">Status</label>
        <select id="status" name="status" class="ui-select" required>
            <option value="scheduled" {{ old('status', $match->status ?? '') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="in_progress" {{ old('status', $match->status ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="finished" {{ old('status', $match->status ?? '') === 'finished' ? 'selected' : '' }}>Finished</option>
        </select>
        @error('status')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="score_a" class="ui-label">Score A</label>
        <input id="score_a" type="number" min="0" name="score_a" value="{{ old('score_a', $match->score_a ?? '') }}" class="ui-input">
        @error('score_a')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="score_b" class="ui-label">Score B</label>
        <input id="score_b" type="number" min="0" name="score_b" value="{{ old('score_b', $match->score_b ?? '') }}" class="ui-input">
        @error('score_b')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-3">
    <x-ui.button type="submit" size="lg">
        {{ $buttonText }}
    </x-ui.button>
    <x-ui.button as="a" :href="route('tournaments.matches.index', $tournament)" variant="secondary" size="lg">
        Cancel
    </x-ui.button>
</div>
