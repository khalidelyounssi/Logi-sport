<x-app-layout>
    <x-slot name="title">Add Participant</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} • add a team or player to the roster.</x-slot>

    <div class="space-y-6">
        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <x-ui.card class="bg-[linear-gradient(90deg,#10213d_0%,#11325a_45%,#156b63_100%)] text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-100/80">Step 2/4</p>
                    <h2 class="mt-1 text-2xl font-black">Participant Registration</h2>
                    <p class="mt-1 text-sm text-slate-200">Add participants before generating matches.</p>
                </div>

                <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary">
                    Back to Participants
                </x-ui.button>
            </div>
        </x-ui.card>

        <x-ui.card>
            <form method="POST" action="{{ route('tournaments.participants.store', $tournament) }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="ui-label">Participant Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="ui-input"
                        placeholder="e.g. Red Hawks"
                        required
                    >
                    @error('name')
                        <p class="ui-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="ui-label">Participant Type</label>
                    <select id="type" name="type" class="ui-select" required>
                        <option value="team" @selected(old('type') === 'team')>Team</option>
                        <option value="player" @selected(old('type') === 'player')>Player</option>
                    </select>
                    @error('type')
                        <p class="ui-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="user_id" class="ui-label">Linked Player (optional)</label>
                    <select id="user_id" name="user_id" class="ui-select">
                        <option value="">No linked user</option>
                        @foreach($players as $player)
                            <option value="{{ $player->id }}" @selected(old('user_id') == $player->id)>
                                {{ $player->name }} — {{ $player->email }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-500">
                        Select an existing player account, or leave empty to create an independent participant.
                    </p>
                    @error('user_id')
                        <p class="ui-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.button type="submit" size="lg">
                        Save Participant
                    </x-ui.button>

                    <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary" size="lg">
                        Cancel
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
