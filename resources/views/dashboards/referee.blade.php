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
            <x-stat-card title="Assigned Matches" value="12" hint="This week" />
            <x-stat-card title="In Progress" value="3" hint="Live games" tone="amber" />
            <x-stat-card title="Completed" value="7" hint="Scores submitted" tone="emerald" />
            <x-stat-card title="Pending" value="2" hint="Need score update" tone="slate" />
        </div>

        <x-ui.card padding="p-0">
            <div class="border-b border-slate-100 px-6 py-5">
                <h3 class="text-lg font-black text-slate-900">Referee Workflow</h3>
                <p class="text-sm text-slate-500">Open a match, update score, set status to finished, and submit.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 p-6 md:grid-cols-3">
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
