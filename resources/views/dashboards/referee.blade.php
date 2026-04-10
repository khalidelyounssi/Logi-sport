<x-app-layout>
    <x-slot name="title">Referee Dashboard</x-slot>
    <x-slot name="subtitle">Manage assigned matches and submit score updates quickly.</x-slot>

    <div class="space-y-6">
        <x-ui.card class="bg-gradient-to-r from-slate-900 to-blue-800 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Referee Panel</p>
                    <h2 class="mt-1 text-2xl font-black">Live Match Management</h2>
                    <p class="mt-1 text-sm text-slate-300">Review your assigned fixtures and update final results.</p>
                </div>

                <x-ui.button as="a" :href="route('referee.matches.index')" variant="secondary" size="lg">
                    🧑‍⚖️ My Matches
                </x-ui.button>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card title="Assigned Matches" :value="$assigned" hint="All assigned matches" />
            <x-stat-card title="In Progress" :value="$inProgress" hint="Live games" tone="amber" />
            <x-stat-card title="Completed" :value="$completed" hint="Scores submitted" tone="emerald" />
            <x-stat-card title="Pending" :value="$pending" hint="Need score update" tone="slate" />
        </div>

        <x-ui.card padding="p-0">
            <div class="border-b border-slate-100 px-6 py-5">
                <h3 class="text-lg font-black text-slate-900">Recent Matches</h3>
                <p class="text-sm text-slate-500">Latest matches assigned to you.</p>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentMatches as $match)
                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ $match->tournament?->title ?? 'Tournament' }}
                            </p>

                            <p class="text-sm text-slate-500">
                                {{ $match->participantA?->name ?? '-' }} vs {{ $match->participantB?->name ?? '-' }}
                                @if(!is_null($match->score_a) || !is_null($match->score_b))
                                    • {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                @endif
                            </p>
                        </div>

                        <x-ui.badge :status="$match->status">
                            {{ str_replace('_', ' ', $match->status) }}
                        </x-ui.badge>
                    </div>
                @empty
                    <div class="px-6 py-6 text-sm text-slate-500">
                        No matches assigned yet.
                    </div>
                @endforelse
            </div>
        </x-ui.card>

        <x-ui.card>
            <h3 class="text-lg font-black text-slate-900">Referee Workflow</h3>

            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Step 1</p>
                    <p class="mt-1 font-semibold text-slate-800">Open Assigned Match</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Step 2</p>
                    <p class="mt-1 font-semibold text-slate-800">Update Scores</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Step 3</p>
                    <p class="mt-1 font-semibold text-slate-800">Confirm Final Status</p>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-app-layout>