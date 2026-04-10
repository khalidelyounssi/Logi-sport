<x-app-layout>
    <x-slot name="title">Edit Participant</x-slot>
    <x-slot name="subtitle">{{ $tournament->title }} • update participant information.</x-slot>

    <div class="space-y-6">
        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <x-ui.card class="bg-gradient-to-r from-slate-900 to-blue-800 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Step 2/4</p>
                    <h2 class="mt-1 text-2xl font-black">Participant Update</h2>
                    <p class="mt-1 text-sm text-slate-300">Keep participant records accurate before match generation.</p>
                </div>

                <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary">
                    Back to Participants
                </x-ui.button>
            </div>
        </x-ui.card>

        <x-ui.card>
            <form method="POST" action="{{ route('tournaments.participants.update', [$tournament, $participant]) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="ui-label">Participant Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $participant->name) }}"
                        class="ui-input"
                        required
                    >
                    @error('name')
                        <p class="ui-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="ui-label">Participant Type</label>
                    <select id="type" name="type" class="ui-select" required>
                        <option value="team" {{ old('type', $participant->type) === 'team' ? 'selected' : '' }}>Team</option>
                        <option value="player" {{ old('type', $participant->type) === 'player' ? 'selected' : '' }}>Player</option>
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
                            <option value="{{ $player->id }}" @selected(old('user_id', $participant->user_id) == $player->id)>
                                {{ $player->name }} — {{ $player->email }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-500">
                        You can link this participant to an existing player account, or leave it empty.
                    </p>
                    @error('user_id')
                        <p class="ui-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.button type="submit" size="lg">
                        Update Participant
                    </x-ui.button>

                    <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary" size="lg">
                        Cancel
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>