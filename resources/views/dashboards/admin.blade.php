<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="subtitle">Platform overview, governance, and system-level insights.</x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card title="Total Users" :value="$totalUsers" hint="All accounts" />
            <x-stat-card title="Total Tournaments" :value="$totalTournaments" hint="All organizers" tone="slate" />
            <x-stat-card title="Active Matches" :value="$activeMatches" hint="Scheduled + in progress" tone="amber" />
            <x-stat-card title="Total Sports" :value="$totalSports" hint="Available disciplines" tone="emerald" />
        </div>

        <x-ui.card class="bg-gradient-to-r from-slate-900 to-blue-900 text-white">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-300">Admin Panel</p>
                    <h2 class="mt-1 text-2xl font-black">Control Center</h2>
                    <p class="mt-1 text-sm text-slate-300">
                        Manage users, monitor usage, and supervise platform activity.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-ui.button as="a" :href="route('admin.users')" variant="secondary">
                        Users
                    </x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <x-ui.card class="xl:col-span-2" padding="p-0">
                <div class="border-b border-slate-100 px-6 py-5">
                    <h3 class="text-lg font-black text-slate-900">Users by Role</h3>
                    <p class="text-sm text-slate-500">Global distribution of platform roles.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 px-4 py-4">
                        <p class="text-sm text-slate-500">Admins</p>
                        <p class="mt-1 text-3xl font-black text-slate-900">{{ $usersByRole['admins'] }}</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-4">
                        <p class="text-sm text-slate-500">Organizers</p>
                        <p class="mt-1 text-3xl font-black text-slate-900">{{ $usersByRole['organizers'] }}</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-4">
                        <p class="text-sm text-slate-500">Referees</p>
                        <p class="mt-1 text-3xl font-black text-slate-900">{{ $usersByRole['referees'] }}</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 px-4 py-4">
                        <p class="text-sm text-slate-500">Players</p>
                        <p class="mt-1 text-3xl font-black text-slate-900">{{ $usersByRole['players'] }}</p>
                    </div>
                </div>

                <div class="border-t border-slate-100 p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-green-50 px-4 py-4">
                            <p class="text-sm text-green-700">Active Users</p>
                            <p class="mt-1 text-2xl font-black text-green-800">{{ $activeUsers }}</p>
                        </div>

                        <div class="rounded-2xl bg-red-50 px-4 py-4">
                            <p class="text-sm text-red-700">Suspended Users</p>
                            <p class="mt-1 text-2xl font-black text-red-800">{{ $suspendedUsers }}</p>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-900">Sports Overview</h3>
                <p class="mt-1 text-sm text-slate-500">Most used disciplines on the platform.</p>

                <div class="mt-4 space-y-3">
                    @forelse($sportsOverview as $sport)
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="font-semibold text-slate-700">{{ $sport->name }}</span>
                            <x-ui.badge variant="info">{{ $sport->tournaments_count }} tournaments</x-ui.badge>
                        </div>
                    @empty
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-500">
                            No sports data available.
                        </div>
                    @endforelse
                </div>
            </x-ui.card>
        </div>

        <x-ui.card padding="p-0">
            <div class="border-b border-slate-100 px-6 py-5">
                <h3 class="text-lg font-black text-slate-900">Recent Users</h3>
                <p class="text-sm text-slate-500">Latest registered accounts.</p>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <x-ui.badge variant="info">{{ $user->role }}</x-ui.badge>

                            @if($user->is_active)
                                <x-ui.badge variant="success">active</x-ui.badge>
                            @else
                                <x-ui.badge variant="danger">suspended</x-ui.badge>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-4 text-sm text-slate-500">
                        No users found.
                    </div>
                @endforelse
            </div>
        </x-ui.card>
    </div>
</x-app-layout>