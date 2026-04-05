<x-app-layout>
    <x-slot name="title">{{ $tournament->title }}</x-slot>
    <x-slot name="subtitle">Tournament details and workflow actions.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        @if($errors->any())
            <x-ui.alert variant="error">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <x-ui.card class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Tournament Flow</p>
                    <h2 class="mt-1 text-2xl font-black">{{ $tournament->title }}</h2>
                    <p class="mt-1 text-sm text-blue-100">Follow: Participants -> Matches -> Standings.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-ui.button as="a" :href="route('tournaments.edit', $tournament)" variant="secondary" size="sm">Edit</x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary" size="sm">Participants</x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.matches.index', $tournament)" variant="secondary" size="sm">Matches</x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.standings.index', $tournament)" variant="secondary" size="sm">Standings</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <x-ui.card class="lg:col-span-2">
                <h3 class="text-lg font-black text-slate-900">Overview</h3>

                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Title</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $tournament->title }}</dd>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Sport</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $tournament->sport?->name ?? '-' }}</dd>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Type</dt>
                        <dd class="mt-1"><x-ui.badge variant="info">{{ str_replace('_', ' ', $tournament->type) }}</x-ui.badge></dd>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Status</dt>
                        <dd class="mt-1"><x-ui.badge :status="$tournament->status">{{ str_replace('_', ' ', $tournament->status) }}</x-ui.badge></dd>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">Start Date</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $tournament->start_date?->format('Y-m-d') ?? '-' }}</dd>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <dt class="text-xs uppercase tracking-[0.18em] text-slate-400">End Date</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $tournament->end_date?->format('Y-m-d') ?? 'Not set' }}</dd>
                    </div>
                </dl>

                <div class="mt-5 rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Description</p>
                    <p class="mt-1 text-sm text-slate-700">{{ $tournament->description ?: 'No description provided.' }}</p>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-900">Actions</h3>
                <div class="mt-4 space-y-2">
                    <x-ui.button as="a" :href="route('tournaments.participants.index', $tournament)" variant="secondary" class="w-full justify-start">
                        👥 Manage Participants
                    </x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.matches.index', $tournament)" variant="secondary" class="w-full justify-start">
                        ⚔️ Manage Matches
                    </x-ui.button>
                    <x-ui.button as="a" :href="route('tournaments.standings.index', $tournament)" variant="secondary" class="w-full justify-start">
                        🥇 View Standings
                    </x-ui.button>

                    @if($tournament->type === 'round_robin')
                        <form action="{{ route('tournaments.generateMatches', $tournament) }}" method="POST" onsubmit="return confirm('Regenerate matches? Existing matches will be replaced.')">
                            @csrf
                            <x-ui.button type="submit" variant="success" class="mt-2 w-full justify-start">
                                ⚙️ Generate Round Robin
                            </x-ui.button>
                        </form>
                    @endif
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
