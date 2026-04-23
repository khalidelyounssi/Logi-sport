<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="subtitle">Supervision globale de la plateforme.</x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-ui.card><p class="ls-stat-label">Utilisateurs</p><p class="ls-stat-value text-emerald-300">{{ $totalUsers }}</p><p class="ls-stat-trend">Platform accounts</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">Tournois</p><p class="ls-stat-value text-cyan-300">{{ $totalTournaments }}</p><p class="ls-stat-trend">Created competitions</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">Matchs actifs</p><p class="ls-stat-value text-amber-300">{{ $activeMatches }}</p><p class="ls-stat-trend">Live operation</p></x-ui.card>
            <x-ui.card><p class="ls-stat-label">Sports</p><p class="ls-stat-value">{{ $totalSports }}</p><p class="ls-stat-trend">Catalog coverage</p></x-ui.card>
        </div>

        <x-ui.card>
            <span class="ls-kicker">Admin Tools</span>
            <h3 class="mt-4 text-2xl font-black text-white">Quick Actions</h3>
            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('admin.users') }}" class="ls-panel-soft p-4 text-center transition hover:border-cyan-400/30">
                    <p class="text-sm text-slate-300">Manage Users</p>
                </a>
                <a href="{{ route('sports.index') }}" class="ls-panel-soft p-4 text-center transition hover:border-emerald-400/30">
                    <p class="text-sm text-slate-300">Manage Sports</p>
                </a>
                <a href="{{ route('tournaments.index') }}" class="ls-panel-soft p-4 text-center transition hover:border-amber-400/30">
                    <p class="text-sm text-slate-300">View Tournaments</p>
                </a>
                <a href="{{ route('admin.users') }}?role=organizer" class="ls-panel-soft p-4 text-center transition hover:border-violet-400/30">
                    <p class="text-sm text-slate-300">Organizers</p>
                </a>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2">
                <x-ui.card>
                    <h3 class="text-lg font-black text-slate-100 mb-4">Utilisateurs récents</h3>
                    @if($recentUsers->isEmpty())
                        <x-ui.empty-state title="Aucun utilisateur" description="Les nouveaux comptes apparaîtront ici." />
                    @else
                        <div class="space-y-3">
                            @foreach($recentUsers as $user)
                                <div class="ls-list-item">
                                    <div>
                                        <p class="font-semibold text-slate-100">{{ $user->name }}</p>
                                        <p class="text-sm text-slate-400">{{ $user->email }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <x-ui.badge>{{ $user->role }}</x-ui.badge>
                                        <x-ui.badge :variant="$user->is_active ? 'success' : 'danger'">{{ $user->is_active ? 'active' : 'suspended' }}</x-ui.badge>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-ui.card>
            </div>

            <x-ui.card>
                <h3 class="text-lg font-black text-slate-100 mb-4">Sports populaires</h3>
                @if($sportsOverview->isEmpty())
                    <x-ui.empty-state title="Pas de données" description="Les statistiques sportives apparaîtront ici." />
                @else
                    <div class="space-y-2">
                        @foreach($sportsOverview as $sport)
                            <div class="ls-list-item px-3 py-2 text-sm text-slate-200">
                                <span>{{ $sport->name }}</span>
                                <span>{{ $sport->tournaments_count ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
