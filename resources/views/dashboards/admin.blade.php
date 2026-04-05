<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="subtitle">Platform overview, governance, and system-level insights.</x-slot>

    @php
        $usersRoute = Route::has('admin.users.index') ? route('admin.users.index') : '#';
        $statsRoute = Route::has('admin.statistics.index') ? route('admin.statistics.index') : '#';
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card title="Total Users" value="245" hint="+12% this month" />
            <x-stat-card title="Total Tournaments" value="64" hint="All organizers" tone="slate" />
            <x-stat-card title="Active Matches" value="38" hint="Live and in-progress" tone="amber" />
            <x-stat-card title="Platform Health" value="99.9%" hint="Operational uptime" tone="emerald" />
        </div>

        <x-ui.card class="bg-gradient-to-r from-slate-900 to-blue-900 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Admin Panel</p>
                    <h2 class="mt-1 text-2xl font-black">Control Center</h2>
                    <p class="mt-1 text-sm text-slate-300">Manage users, monitor usage, and supervise platform activity.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-ui.button as="a" :href="$usersRoute" variant="secondary" :class="!Route::has('admin.users.index') ? 'pointer-events-none opacity-50' : ''">
                        Users
                    </x-ui.button>
                    <x-ui.button as="a" :href="$statsRoute" variant="secondary" :class="!Route::has('admin.statistics.index') ? 'pointer-events-none opacity-50' : ''">
                        Statistics
                    </x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <x-ui.card class="xl:col-span-2" padding="p-0">
                <div class="border-b border-slate-100 px-6 py-5">
                    <h3 class="text-lg font-black text-slate-900">Recent Platform Activity</h3>
                    <p class="text-sm text-slate-500">Quick summary of system events.</p>
                </div>

                <div class="divide-y divide-slate-100">
                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-900">New organizer account approved</p>
                            <p class="text-sm text-slate-500">2 minutes ago</p>
                        </div>
                        <x-ui.badge variant="success">done</x-ui.badge>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-900">Tournament traffic spike detected</p>
                            <p class="text-sm text-slate-500">10 minutes ago</p>
                        </div>
                        <x-ui.badge variant="warning">monitoring</x-ui.badge>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-900">Monthly report generated</p>
                            <p class="text-sm text-slate-500">Today</p>
                        </div>
                        <x-ui.badge variant="info">report</x-ui.badge>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-900">Sports Overview</h3>
                <p class="mt-1 text-sm text-slate-500">Most used disciplines on the platform.</p>

                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="font-semibold text-slate-700">⚽ Football</span>
                        <x-ui.badge variant="info">34%</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="font-semibold text-slate-700">🏀 Basketball</span>
                        <x-ui.badge variant="warning">27%</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="font-semibold text-slate-700">🎾 Tennis</span>
                        <x-ui.badge variant="success">18%</x-ui.badge>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
