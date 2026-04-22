<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logi-Sport | Organisez vos tournois facilement</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 antialiased">
    @php
        $dashboardRoute = null;
        $publicMatches = $publicMatches ?? [];
        $initialMatchDay = $initialMatchDay ?? 'next7days';
        $matchRefreshSeconds = $matchRefreshSeconds ?? 30;

        if (auth()->check()) {
            $dashboardRoute = match (auth()->user()->role) {
                'admin' => route('admin.dashboard'),
                'organizer' => route('organizer.dashboard'),
                'referee' => route('referee.dashboard'),
                'player' => route('player.dashboard'),
                default => url('/'),
            };
        }
    @endphp

    <!-- Navbar -->
    <header class="border-b border-slate-800/80 bg-slate-950/90 backdrop-blur sticky top-0 z-50">
        <div class="w-full px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="text-xl font-bold tracking-tight">
                Logi<span class="text-emerald-400">Sport</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm text-slate-300">
                <a href="#features" class="hover:text-white transition">Fonctionnalités</a>
                <a href="#how" class="hover:text-white transition">Comment ça marche</a>
                <a href="#cta" class="hover:text-white transition">Commencer</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ $dashboardRoute }}"
                       class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-semibold text-sm transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-xl border border-slate-700 hover:border-slate-500 text-sm transition">
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-semibold text-sm transition">
                        S’inscrire
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(16,185,129,0.15),_transparent_45%)]"></div>
        <div class="w-full px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative">
            <div class="w-full">
                <p class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.2em] text-emerald-300/90 mb-6">
                    SaaS Tournament Platform
                </p>
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                    Organisez vos tournois sportifs
                    <span class="text-emerald-400">sans complexité</span>
                </h1>
                <p class="mt-6 text-slate-300 text-lg leading-relaxed">
                    Logi-Sport aide les organisateurs à créer des tournois, générer automatiquement les calendriers,
                    gérer les scores en temps réel et afficher les classements instantanément.
                </p>

                <div class="mt-10 flex flex-wrap items-center gap-4">
                    @auth
                        <a href="{{ $dashboardRoute }}"
                           class="px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold transition">
                            Aller au Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold transition">
                            Commencer maintenant
                        </a>
                        <a href="{{ route('login') }}"
                           class="px-6 py-3 rounded-2xl border border-slate-700 hover:border-slate-500 font-semibold transition">
                            Découvrir la plateforme
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Public Matches -->
    <section id="public-matches" class="py-16 md:py-20 border-t border-slate-800/70">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold">Matchs publics</h2>
                    <p class="text-slate-400 mt-2">Aperçu des matchs récents et à venir pour les visiteurs.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" data-day="next7days" class="js-day-filter rounded-xl border border-emerald-500/40 bg-emerald-500/20 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-emerald-300">Next 7 days</button>
                    <button type="button" data-day="today" class="js-day-filter rounded-xl border border-emerald-500/40 bg-emerald-500/20 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-emerald-300">Today</button>
                    <button type="button" data-day="tomorrow" class="js-day-filter rounded-xl border border-slate-700 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-slate-300 hover:border-slate-500">Tomorrow</button>
                    <span class="text-xs uppercase tracking-[0.18em] text-slate-500">Source: football-data.org</span>
                </div>
            </div>

            <p id="matches-last-updated" class="mt-4 text-xs text-slate-500">Updated from server cache.</p>

            <div id="public-matches-grid" class="mt-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($publicMatches as $match)
                    @php
                        $statusClass = match ($match['status']) {
                            'IN_PLAY', 'LIVE' => 'bg-rose-500/20 text-rose-300 border-rose-500/30',
                            'FINISHED' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                            default => 'bg-slate-700/40 text-slate-300 border-slate-600',
                        };
                    @endphp
                    <article class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs uppercase tracking-[0.18em] text-slate-500 truncate">{{ $match['competition'] }}</p>
                            <span class="rounded-full border px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.15em] {{ $statusClass }}">{{ $match['status_label'] }}</span>
                        </div>
                        <div class="mt-4 flex items-center justify-between gap-3">
                            <p class="text-sm font-semibold text-slate-100 truncate">{{ $match['home'] }}</p>
                            <p class="text-xs text-slate-500">vs</p>
                            <p class="text-sm font-semibold text-slate-100 truncate text-right">{{ $match['away'] }}</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            @if(!is_null($match['score_home']) && !is_null($match['score_away']))
                                <p class="text-lg font-black text-emerald-300">{{ $match['score_home'] }} - {{ $match['score_away'] }}</p>
                            @else
                                <p class="text-sm text-slate-400">No score yet</p>
                            @endif
                            <p class="text-xs text-slate-500">{{ $match['kickoff'] ?? 'TBD' }}</p>
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 rounded-2xl border border-slate-800 bg-slate-900/50 p-6 text-slate-400">
                        Match feed unavailable for now. Please try again shortly.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-16 md:py-24 border-t border-slate-800/70">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold">Fonctionnalités clés</h2>
            <p class="text-slate-400 mt-3 max-w-2xl">
                Tout ce qu’il faut pour piloter un tournoi amateur, quel que soit le sport.
            </p>

            <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <article class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800">
                    <h3 class="font-semibold text-lg">Gestion des tournois</h3>
                    <p class="mt-2 text-slate-400 text-sm">
                        Créez, modifiez et suivez vos compétitions depuis un tableau de bord unique.
                    </p>
                </article>

                <article class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800">
                    <h3 class="font-semibold text-lg">Calendrier automatique</h3>
                    <p class="mt-2 text-slate-400 text-sm">
                        Générez les matchs automatiquement selon le format du tournoi.
                    </p>
                </article>

                <article class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800">
                    <h3 class="font-semibold text-lg">Scores en temps réel</h3>
                    <p class="mt-2 text-slate-400 text-sm">
                        Les arbitres saisissent les résultats, les classements se mettent à jour rapidement.
                    </p>
                </article>

                <article class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800">
                    <h3 class="font-semibold text-lg">Classements dynamiques</h3>
                    <p class="mt-2 text-slate-400 text-sm">
                        Affichage automatique des points, victoires, défaites et performances.
                    </p>
                </article>

                <article class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800">
                    <h3 class="font-semibold text-lg">Multi-rôles</h3>
                    <p class="mt-2 text-slate-400 text-sm">
                        Organisateur, joueur, arbitre, administrateur: chaque profil a son espace dédié.
                    </p>
                </article>

                <article class="p-6 rounded-2xl bg-slate-900/70 border border-slate-800">
                    <h3 class="font-semibold text-lg">Statistiques utiles</h3>
                    <p class="mt-2 text-slate-400 text-sm">
                        Analysez l’évolution des tournois et les performances des équipes/joueurs.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section id="how" class="py-16 md:py-24 border-t border-slate-800/70">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold">Comment ça marche</h2>
            <div class="mt-10 grid md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl border border-slate-800 bg-slate-900/40">
                    <p class="text-emerald-400 font-bold text-sm">Étape 1</p>
                    <h3 class="mt-2 font-semibold">Créer un tournoi</h3>
                    <p class="mt-2 text-sm text-slate-400">Choisissez le sport, le type et les dates.</p>
                </div>
                <div class="p-6 rounded-2xl border border-slate-800 bg-slate-900/40">
                    <p class="text-emerald-400 font-bold text-sm">Étape 2</p>
                    <h3 class="mt-2 font-semibold">Générer les matchs</h3>
                    <p class="mt-2 text-sm text-slate-400">Le calendrier est généré automatiquement.</p>
                </div>
                <div class="p-6 rounded-2xl border border-slate-800 bg-slate-900/40">
                    <p class="text-emerald-400 font-bold text-sm">Étape 3</p>
                    <h3 class="mt-2 font-semibold">Suivre les résultats</h3>
                    <p class="mt-2 text-sm text-slate-400">Scores, classements et stats en un seul endroit.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="cta" class="py-20 border-t border-slate-800/70">
        <div class="w-full px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold">Prêt à lancer votre prochain tournoi ?</h2>
            <p class="mt-4 text-slate-400">
                Rejoignez Logi-Sport et simplifiez toute votre organisation sportive.
            </p>
            <div class="mt-8 flex justify-center gap-4 flex-wrap">
                @auth
                    <a href="{{ $dashboardRoute }}"
                       class="px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold transition">
                        Ouvrir mon dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold transition">
                        Créer un compte
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 rounded-2xl border border-slate-700 hover:border-slate-500 font-semibold transition">
                        Se connecter
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <footer class="border-t border-slate-800 py-8 text-center text-sm text-slate-500">
        © {{ date('Y') }} Logi-Sport. Tous droits réservés.
    </footer>

    <script>
        (() => {
            const feedUrl = "{{ route('public.matches.feed') }}";
            const refreshMs = Math.max(10, Number("{{ $matchRefreshSeconds }}")) * 1000;
            const grid = document.getElementById('public-matches-grid');
            const updatedAt = document.getElementById('matches-last-updated');
            const dayButtons = document.querySelectorAll('.js-day-filter');
            let currentDay = "{{ $initialMatchDay }}";

            const statusClass = (status) => {
                if (status === 'IN_PLAY' || status === 'LIVE') return 'bg-rose-500/20 text-rose-300 border-rose-500/30';
                if (status === 'FINISHED') return 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30';
                return 'bg-slate-700/40 text-slate-300 border-slate-600';
            };

            const escapeHtml = (value) => String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            const setActiveDay = (day) => {
                currentDay = day;
                dayButtons.forEach((btn) => {
                    const isActive = btn.dataset.day === day;
                    btn.className = isActive
                        ? 'js-day-filter rounded-xl border border-emerald-500/40 bg-emerald-500/20 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-emerald-300'
                        : 'js-day-filter rounded-xl border border-slate-700 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-slate-300 hover:border-slate-500';
                });
            };

            const renderMatches = (matches) => {
                if (!Array.isArray(matches) || matches.length === 0) {
                    grid.innerHTML = `
                        <div class="md:col-span-2 xl:col-span-3 rounded-2xl border border-slate-800 bg-slate-900/50 p-6 text-slate-400">
                            No matches found for this range.
                        </div>
                    `;
                    return;
                }

                grid.innerHTML = matches.map((match) => {
                    const score = (match.score_home !== null && match.score_away !== null)
                        ? `<p class="text-lg font-black text-emerald-300">${escapeHtml(match.score_home)} - ${escapeHtml(match.score_away)}</p>`
                        : `<p class="text-sm text-slate-400">No score yet</p>`;

                    return `
                        <article class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 truncate">${escapeHtml(match.competition)}</p>
                                <span class="rounded-full border px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.15em] ${statusClass(match.status)}">${escapeHtml(match.status_label)}</span>
                            </div>
                            <div class="mt-4 flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-slate-100 truncate">${escapeHtml(match.home)}</p>
                                <p class="text-xs text-slate-500">vs</p>
                                <p class="text-sm font-semibold text-slate-100 truncate text-right">${escapeHtml(match.away)}</p>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                ${score}
                                <p class="text-xs text-slate-500">${escapeHtml(match.kickoff ?? 'TBD')}</p>
                            </div>
                        </article>
                    `;
                }).join('');
            };

            const fetchMatches = async (day = currentDay) => {
                try {
                    const response = await fetch(`${feedUrl}?day=${encodeURIComponent(day)}`, {
                        headers: { 'Accept': 'application/json' },
                    });

                    if (!response.ok) {
                        throw new Error('Feed request failed');
                    }

                    const payload = await response.json();
                    setActiveDay(payload.day || day);
                    renderMatches(payload.matches || []);
                    updatedAt.textContent = `Last updated: ${payload.updated_at || ''}`;
                } catch (error) {
                    updatedAt.textContent = 'Feed temporarily unavailable.';
                }
            };

            dayButtons.forEach((btn) => {
                btn.addEventListener('click', () => fetchMatches(btn.dataset.day));
            });

            setActiveDay(currentDay);
            fetchMatches(currentDay);
            setInterval(() => fetchMatches(currentDay), refreshMs);
        })();
    </script>
</body>
</html>