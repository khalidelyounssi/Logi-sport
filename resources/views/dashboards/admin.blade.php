<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="subtitle">Supervision globale de la plateforme.</x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <x-ui.card><p class="text-xs text-slate-400 uppercase">Utilisateurs</p><p class="text-3xl font-black text-emerald-300 mt-2">{{ $totalUsers }}</p></x-ui.card>
            <x-ui.card><p class="text-xs text-slate-400 uppercase">Tournois</p><p class="text-3xl font-black text-cyan-300 mt-2">{{ $totalTournaments }}</p></x-ui.card>
            <x-ui.card><p class="text-xs text-slate-400 uppercase">Matchs actifs</p><p class="text-3xl font-black text-amber-300 mt-2">{{ $activeMatches }}</p></x-ui.card>
            <x-ui.card><p class="text-xs text-slate-400 uppercase">Sports</p><p class="text-3xl font-black text-slate-100 mt-2">{{ $totalSports }}</p></x-ui.card>
        </div>

        <x-ui.card>
            <div class="flex flex-wrap gap-3">
                <x-ui.button as="a" :href="route('admin.users')">Gérer les utilisateurs</x-ui.button>
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
                                <div class="rounded-xl bg-slate-800/60 p-4 flex items-center justify-between">
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
                            <div class="rounded-xl bg-slate-800/60 px-3 py-2 text-sm text-slate-200 flex justify-between">
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