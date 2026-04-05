<x-app-layout>
    <x-slot name="title">Player Dashboard</x-slot>
    <x-slot name="subtitle">Follow your tournaments, match results, and performance trends.</x-slot>

    @php
        $myTournamentsRoute = Route::has('player.tournaments.index') ? route('player.tournaments.index') : '#';
    @endphp

    <div class="space-y-6">
        <x-ui.card class="bg-gradient-to-r from-blue-700 to-indigo-700 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Player Space</p>
                    <h2 class="mt-1 text-2xl font-black">Performance Hub</h2>
                    <p class="mt-1 text-sm text-blue-100">Track rankings, recent matches, and your tournament history.</p>
                </div>

                <x-ui.button as="a" :href="$myTournamentsRoute" variant="secondary" size="lg" :class="!Route::has('player.tournaments.index') ? 'pointer-events-none opacity-50' : ''">
                    🎮 My Tournaments
                </x-ui.button>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card title="Matches Played" value="18" hint="This season" />
            <x-stat-card title="Wins" value="10" hint="Win rate 56%" tone="emerald" />
            <x-stat-card title="Goals / Points" value="12" hint="Overall contribution" tone="blue" />
            <x-stat-card title="Rank" value="#4" hint="Current ladder" tone="amber" />
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <x-ui.card class="xl:col-span-2" padding="p-0">
                <div class="border-b border-slate-100 px-6 py-5">
                    <h3 class="text-lg font-black text-slate-900">Recent Matches</h3>
                    <p class="text-sm text-slate-500">Your latest activity and outcomes.</p>
                </div>

                <div class="divide-y divide-slate-100">
                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-800">City League • Round 5</p>
                            <p class="text-sm text-slate-500">Falcons vs Raptors</p>
                        </div>
                        <x-ui.badge variant="success">Win</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-800">Summer Cup • Group Stage</p>
                            <p class="text-sm text-slate-500">Raptors vs Hawks</p>
                        </div>
                        <x-ui.badge variant="warning">Draw</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-800">Regional Open • Quarterfinal</p>
                            <p class="text-sm text-slate-500">Raptors vs Wolves</p>
                        </div>
                        <x-ui.badge variant="danger">Loss</x-ui.badge>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-900">Performance Snapshot</h3>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-slate-600">Average score</span>
                        <span class="font-black text-blue-700">7.9</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-slate-600">Win rate</span>
                        <span class="font-black text-emerald-600">56%</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-slate-600">Streak</span>
                        <span class="font-black text-amber-600">2W</span>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
