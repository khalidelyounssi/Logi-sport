@csrf

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="title" class="ui-label">Tournament Title</label>
        <input id="title" type="text" name="title" value="{{ old('title', $tournament->title ?? '') }}" class="ui-input" placeholder="e.g. Summer Championship" required>
        @error('title')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="description" class="ui-label">Description</label>
        <textarea id="description" name="description" rows="4" class="ui-textarea" placeholder="Describe your tournament">{{ old('description', $tournament->description ?? '') }}</textarea>
        @error('description')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="type" class="ui-label">Tournament Type</label>
        <select id="type" name="type" class="ui-select" required>
            <option value="round_robin" {{ old('type', $tournament->type ?? '') === 'round_robin' ? 'selected' : '' }}>Round Robin</option>
            <option value="elimination" {{ old('type', $tournament->type ?? '') === 'elimination' ? 'selected' : '' }}>Elimination</option>
        </select>
        @error('type')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="sport_id" class="ui-label">Sport</label>
        <select id="sport_id" name="sport_id" class="ui-select" required>
            @foreach($sports as $sport)
                <option value="{{ $sport->id }}" {{ old('sport_id', $tournament->sport_id ?? '') == $sport->id ? 'selected' : '' }}>
                    {{ $sport->name }}
                </option>
            @endforeach
        </select>
        @error('sport_id')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="start_date" class="ui-label">Start Date</label>
        <input id="start_date" type="date" name="start_date" value="{{ old('start_date', isset($tournament) && $tournament->start_date ? $tournament->start_date->format('Y-m-d') : '') }}" class="ui-input" required>
        @error('start_date')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="end_date" class="ui-label">End Date</label>
        <input id="end_date" type="date" name="end_date" value="{{ old('end_date', isset($tournament) && $tournament->end_date ? $tournament->end_date->format('Y-m-d') : '') }}" class="ui-input">
        @error('end_date')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="ui-label">Status</label>
        <select id="status" name="status" class="ui-select" required>
            <option value="draft" {{ old('status', $tournament->status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="upcoming" {{ old('status', $tournament->status ?? '') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
            <option value="live" {{ old('status', $tournament->status ?? '') === 'live' ? 'selected' : '' }}>Live</option>
            <option value="completed" {{ old('status', $tournament->status ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
        @error('status')
            <p class="ui-field-error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-3">
    <x-ui.button type="submit" variant="primary" size="lg">
        {{ $buttonText }}
    </x-ui.button>

    <x-ui.button as="a" :href="route('tournaments.index')" variant="secondary" size="lg">
        Cancel
    </x-ui.button>
</div>
