@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-2">Title</label>
        <input type="text" name="title" value="{{ old('title', $tournament->title ?? '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
        @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
        <textarea name="description" rows="4"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $tournament->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Type</label>
        <select name="type" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            <option value="round_robin" {{ old('type', $tournament->type ?? '') === 'round_robin' ? 'selected' : '' }}>Round Robin</option>
            <option value="elimination" {{ old('type', $tournament->type ?? '') === 'elimination' ? 'selected' : '' }}>Elimination</option>
        </select>
        @error('type')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Sport</label>
        <select name="sport_id" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            @foreach($sports as $sport)
                <option value="{{ $sport->id }}" {{ old('sport_id', $tournament->sport_id ?? '') == $sport->id ? 'selected' : '' }}>
                    {{ $sport->name }}
                </option>
            @endforeach
        </select>
        @error('sport_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($tournament) && $tournament->start_date ? $tournament->start_date->format('Y-m-d') : '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
        @error('start_date')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">End Date</label>
        <input type="date" name="end_date" value="{{ old('end_date', isset($tournament) && $tournament->end_date ? $tournament->end_date->format('Y-m-d') : '') }}"
            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
        @error('end_date')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
            <option value="draft" {{ old('status', $tournament->status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="upcoming" {{ old('status', $tournament->status ?? '') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
            <option value="live" {{ old('status', $tournament->status ?? '') === 'live' ? 'selected' : '' }}>Live</option>
            <option value="completed" {{ old('status', $tournament->status ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
        @error('status')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex items-center gap-4">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold">
        {{ $buttonText }}
    </button>

    <a href="{{ route('tournaments.index') }}" class="px-6 py-3 rounded-2xl border border-slate-300 text-slate-600">
        Cancel
    </a>
</div>