<x-app-layout>
    <x-slot name="title">My Profile</x-slot>
    <x-slot name="subtitle">Informations personnelles et performances.</x-slot>

    <div class="space-y-6">
        <x-ui.card>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-xl font-black text-emerald-300">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-100">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-400">{{ $user->email }}</p>
                        <p class="text-xs text-slate-500 mt-1">Inscrit le {{ $user->created_at?->format('Y-m-d') }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-ui.button as="a" :href="route('player.matches')" variant="secondary">Mes matchs</x-ui.button>
                    <x-ui.button as="a" :href="route('player.tournaments')" variant="secondary">Mes tournois</x-ui.button>
                    @if(Route::has('profile.edit'))
                        <x-ui.button as="a" :href="route('profile.edit')">Modifier compte</x-ui.button>
                    @endif
                </div>
            </div>
        </x-ui.card>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <x-ui.card>
                <p class="text-xs uppercase text-slate-400">Tournois</p>
                <p class="text-3xl font-black text-emerald-300 mt-2">{{ $myTournamentsCount }}</p>
            </x-ui.card>
            <x-ui.card>
                <p class="text-xs uppercase text-slate-400">Matchs joués</p>
                <p class="text-3xl font-black text-cyan-300 mt-2">{{ $matchesPlayed }}</p>
            </x-ui.card>
            <x-ui.card>
                <p class="text-xs uppercase text-slate-400">Victoires</p>
                <p class="text-3xl font-black text-amber-300 mt-2">{{ $wins }}</p>
            </x-ui.card>
            <x-ui.card>
                <p class="text-xs uppercase text-slate-400">Meilleur rang</p>
                <p class="text-3xl font-black text-slate-100 mt-2">{{ $rank }}</p>
            </x-ui.card>
        </div>

        <x-ui.card>
            <h3 class="text-lg font-black text-slate-100 mb-4">Performance</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-xl bg-slate-800/60 p-4">
                    <p class="text-sm text-slate-400">Total points/buts</p>
                    <p class="text-2xl font-black text-emerald-300 mt-1">{{ $goalsOrPoints }}</p>
                </div>
                <div class="rounded-xl bg-slate-800/60 p-4">
                    <p class="text-sm text-slate-400">Win rate</p>
                    <p class="text-2xl font-black text-cyan-300 mt-1">
                        {{ $matchesPlayed > 0 ? round(($wins / $matchesPlayed) * 100, 1) : 0 }}%
                    </p>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <h3 class="text-lg font-black text-slate-100 mb-4">Historique récent</h3>

            @if($recentMatches->isEmpty())
                <x-ui.empty-state title="Aucun match" description="Votre historique s'affichera ici." />
            @else
                <div class="space-y-3">
                    @foreach($recentMatches as $match)
                        <div class="rounded-xl bg-slate-800/60 p-4 flex items-center justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-100">
                                    {{ $match->participantA?->name ?? 'A' }} vs {{ $match->participantB?->name ?? 'B' }}
                                </p>
                                <p class="text-sm text-slate-400">
                                    {{ $match->tournament?->title ?? 'Tournament' }}
                                    @if(!is_null($match->score_a) || !is_null($match->score_b))
                                        • {{ $match->score_a ?? 0 }} - {{ $match->score_b ?? 0 }}
                                    @endif
                                </p>
                            </div>
                            <x-ui.badge :status="$match->status">{{ $match->status }}</x-ui.badge>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-ui.card>
    </div>
</x-app-layout>
