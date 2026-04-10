<x-app-layout>
    <x-slot name="title">Update Match Score</x-slot>
    <x-slot name="subtitle">Submit official score and match status.</x-slot>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <x-ui.card class="xl:col-span-2" padding="p-0">
            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Assigned Match</p>
                        <h2 class="mt-1 text-xl font-black text-slate-900">
                            {{ $match->participantA?->name }} vs {{ $match->participantB?->name }}
                        </h2>
                    </div>

                    <x-ui.badge :status="$match->status">
                        {{ str_replace('_', ' ', $match->status) }}
                    </x-ui.badge>
                </div>
            </div>

            <form action="{{ route('referee.matches.update', $match) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <input type="hidden" name="score_a" id="score_a" value="{{ old('score_a', $match->score_a ?? 0) }}">
                <input type="hidden" name="score_b" id="score_b" value="{{ old('score_b', $match->score_b ?? 0) }}">
                <input type="hidden" name="expected_updated_at" value="{{ optional($match->updated_at)?->toISOString() }}">

                @if(session('error'))
                    <x-ui.alert variant="error">
                        {{ session('error') }}
                    </x-ui.alert>
                @endif

                @if($errors->any())
                    <x-ui.alert variant="error">
                        {{ $errors->first() }}
                    </x-ui.alert>
                @endif

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Participant A</p>
                        <h3 class="mt-2 text-2xl font-black text-slate-900">{{ $match->participantA?->name }}</h3>

                        <div class="mt-6 flex items-center justify-center gap-6">
                            <button
                                type="button"
                                onclick="decreaseScore('score_a', 'score_a_display')"
                                class="inline-flex h-12 w-12 items-center justify-center rounded-full border border-blue-200 text-2xl font-bold text-blue-600 transition hover:bg-blue-50"
                            >
                                -
                            </button>

                            <span id="score_a_display" class="text-6xl font-black text-blue-700">
                                {{ old('score_a', $match->score_a ?? 0) }}
                            </span>

                            <button
                                type="button"
                                onclick="increaseScore('score_a', 'score_a_display')"
                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-blue-600 text-2xl font-bold text-white transition hover:bg-blue-700"
                            >
                                +
                            </button>
                        </div>

                        @error('score_a')
                            <p class="ui-field-error mt-3">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Participant B</p>
                        <h3 class="mt-2 text-2xl font-black text-slate-900">{{ $match->participantB?->name }}</h3>

                        <div class="mt-6 flex items-center justify-center gap-6">
                            <button
                                type="button"
                                onclick="decreaseScore('score_b', 'score_b_display')"
                                class="inline-flex h-12 w-12 items-center justify-center rounded-full border border-blue-200 text-2xl font-bold text-blue-600 transition hover:bg-blue-50"
                            >
                                -
                            </button>

                            <span id="score_b_display" class="text-6xl font-black text-blue-700">
                                {{ old('score_b', $match->score_b ?? 0) }}
                            </span>

                            <button
                                type="button"
                                onclick="increaseScore('score_b', 'score_b_display')"
                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-blue-600 text-2xl font-bold text-white transition hover:bg-blue-700"
                            >
                                +
                            </button>
                        </div>

                        @error('score_b')
                            <p class="ui-field-error mt-3">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="status" class="ui-label">Status</label>
                    <select id="status" name="status" class="ui-select">
                        <option value="scheduled" {{ old('status', $match->status) === 'scheduled' ? 'selected' : '' }}>
                            Scheduled
                        </option>
                        <option value="in_progress" {{ old('status', $match->status) === 'in_progress' ? 'selected' : '' }}>
                            In Progress
                        </option>
                        <option value="finished" {{ old('status', $match->status) === 'finished' ? 'selected' : '' }}>
                            Finished
                        </option>
                    </select>

                    @error('status')
                        <p class="ui-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.button type="submit" size="lg">
                        Save Score
                    </x-ui.button>

                    <x-ui.button as="a" :href="route('referee.matches.index')" variant="secondary" size="lg">
                        Back
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>

        <x-ui.card>
            <h3 class="text-lg font-black text-slate-900">Match Context</h3>

            <div class="mt-4 space-y-4 text-sm">
                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Tournament</p>
                    <p class="mt-1 font-semibold text-slate-800">{{ $match->tournament?->title }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Date</p>
                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $match->match_date?->format('Y-m-d H:i') ?? 'Not scheduled' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Location</p>
                    <p class="mt-1 font-semibold text-slate-800">{{ $match->location ?? 'No location' }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Referee</p>
                    <p class="mt-1 font-semibold text-slate-800">{{ $match->referee?->name }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    <script>
        function increaseScore(inputId, displayId) {
            const input = document.getElementById(inputId);
            const display = document.getElementById(displayId);

            let value = parseInt(input.value, 10) || 0;
            value++;
            input.value = value;
            display.textContent = value;
        }

        function decreaseScore(inputId, displayId) {
            const input = document.getElementById(inputId);
            const display = document.getElementById(displayId);

            let value = parseInt(input.value, 10) || 0;

            if (value > 0) {
                value--;
            }

            input.value = value;
            display.textContent = value;
        }
    </script>
</x-app-layout>