<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logi-Sport | Organisez vos tournois facilement</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-logi antialiased">
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

    <div class="ls-shell">
        <header class="ls-topbar sticky top-0 z-50">
            <div class="mx-auto flex w-full max-w-[1480px] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="/" class="flex items-center gap-3">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-[18px] border border-emerald-400/30 bg-emerald-400/10 text-emerald-300">
                        <x-logo-mark class="h-7 w-7" />
                    </span>
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.28em] text-slate-500">Logi-Sport</p>
                        <p class="text-lg font-black text-white">Tournament OS</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-2 lg:flex">
                    <a href="#features" class="ls-nav-link ls-nav-link-inactive">Fonctionnalités</a>
                    <a href="#public-matches" class="ls-nav-link ls-nav-link-inactive">Live Scores</a>
                    <a href="#how" class="ls-nav-link ls-nav-link-inactive">Workflow</a>
                    <a href="#cta" class="ls-nav-link ls-nav-link-inactive">Commencer</a>
                </nav>

                <div class="flex items-center gap-3">
                    @auth
                        <x-ui.button as="a" :href="$dashboardRoute" variant="primary">Dashboard</x-ui.button>
                    @else
                        <x-ui.button as="a" :href="route('login')" variant="ghost">Login</x-ui.button>
                        <x-ui.button as="a" :href="route('register')" variant="primary">Register</x-ui.button>
                    @endauth
                </div>
            </div>
        </header>

        <main class="relative z-10">
            <section class="px-4 pb-12 pt-8 sm:px-6 lg:px-8 lg:pb-16 lg:pt-10">
                <div class="mx-auto grid w-full max-w-[1480px] gap-8 xl:grid-cols-[minmax(0,1.1fr)_460px]">
                    <div class="ls-panel overflow-hidden p-8 lg:p-10">
                        <span class="ls-kicker">Elite Tournament Management</span>
                        <h1 class="mt-6 max-w-3xl text-4xl font-black leading-[1.02] text-white md:text-6xl">
                            Organisez vos tournois avec une interface premium pensée pour les pros.
                        </h1>
                        <p class="mt-6 max-w-2xl text-base leading-8 text-slate-300">
                            Gérez les compétitions, les participants, les scores en direct et les classements depuis un cockpit sombre, immersif et ultra lisible.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <x-ui.button as="a" :href="$dashboardRoute" variant="primary" size="lg">Ouvrir le dashboard</x-ui.button>
                            @else
                                <x-ui.button as="a" :href="route('register')" variant="primary" size="lg">Commencer maintenant</x-ui.button>
                                <x-ui.button as="a" :href="route('login')" variant="secondary" size="lg">Voir la plateforme</x-ui.button>
                            @endauth
                        </div>

                        <div class="mt-10 grid gap-4 md:grid-cols-3">
                            <div class="ls-panel-soft p-4">
                                <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Modules</p>
                                <p class="mt-3 text-3xl font-black text-white">08</p>
                                <p class="mt-2 text-sm text-slate-400">Dashboards et gestion métier.</p>
                            </div>
                            <div class="ls-panel-soft p-4">
                                <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Live Ops</p>
                                <p class="mt-3 text-3xl font-black text-white">24/7</p>
                                <p class="mt-2 text-sm text-slate-400">Scores et suivi en temps réel.</p>
                            </div>
                            <div class="ls-panel-soft p-4">
                                <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Roles</p>
                                <p class="mt-3 text-3xl font-black text-white">04</p>
                                <p class="mt-2 text-sm text-slate-400">Admin, organizer, referee, player.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6">
                        <div class="ls-panel p-6">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Live Preview</p>
                                    <h2 class="mt-2 text-2xl font-black text-white">Upcoming Showdowns</h2>
                                </div>
                                <span class="ls-kicker">Today</span>
                            </div>

                            <div class="mt-6 space-y-4">
                                @forelse(array_slice($publicMatches, 0, 3) as $match)
                                    <article class="ls-list-item">
                                        <div class="min-w-0">
                                            <p class="text-xs uppercase tracking-[0.18em] text-slate-500">{{ $match['competition'] }}</p>
                                            <p class="mt-2 truncate text-base font-bold text-white">{{ $match['home'] }} <span class="text-slate-500">vs</span> {{ $match['away'] }}</p>
                                            <p class="mt-1 text-xs text-slate-500">{{ $match['kickoff'] ?? 'TBD' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-black text-emerald-300">
                                                @if(!is_null($match['score_home']) && !is_null($match['score_away']))
                                                    {{ $match['score_home'] }} - {{ $match['score_away'] }}
                                                @else
                                                    --
                                                @endif
                                            </p>
                                            <p class="mt-1 text-[11px] uppercase tracking-[0.18em] text-slate-500">{{ $match['status_label'] }}</p>
                                        </div>
                                    </article>
                                @empty
                                    <div class="ls-panel-soft p-5 text-sm text-slate-400">
                                        Match feed unavailable for now. Please try again shortly.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="ls-panel p-6">
                            <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Why teams choose Logi-Sport</p>
                            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                <div class="ls-panel-soft p-4">
                                    <p class="font-semibold text-white">Visual Control</p>
                                    <p class="mt-2 text-sm text-slate-400">A clean, high-contrast interface for operations under pressure.</p>
                                </div>
                                <div class="ls-panel-soft p-4">
                                    <p class="font-semibold text-white">Fast Decisions</p>
                                    <p class="mt-2 text-sm text-slate-400">See standings, schedules and statuses instantly.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="public-matches" class="border-t border-slate-800/60 px-4 py-16 sm:px-6 lg:px-8">
                <div class="mx-auto w-full max-w-[1480px]">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <span class="ls-kicker">Public Matches</span>
                            <h2 class="mt-4 text-3xl font-black text-white md:text-4xl">Live action from public competitions</h2>
                            <p class="mt-3 text-sm text-slate-400">A dynamic feed for visitors with the same visual language as the private dashboards.</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" data-day="next7days" class="js-day-filter rounded-2xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-2 text-xs font-black uppercase tracking-[0.16em] text-emerald-300">Next 7 days</button>
                            <button type="button" data-day="today" class="js-day-filter rounded-2xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-2 text-xs font-black uppercase tracking-[0.16em] text-emerald-300">Today</button>
                            <button type="button" data-day="tomorrow" class="js-day-filter rounded-2xl border border-slate-700/80 bg-slate-950/70 px-4 py-2 text-xs font-black uppercase tracking-[0.16em] text-slate-300">Tomorrow</button>
                        </div>
                    </div>

                    <p id="matches-last-updated" class="mt-4 text-xs uppercase tracking-[0.18em] text-slate-500">Updated from server cache every {{ $matchRefreshSeconds }} seconds.</p>

                    <div id="public-matches-grid" class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @forelse($publicMatches as $match)
                            @php
                                $statusClass = match ($match['status']) {
                                    'IN_PLAY', 'LIVE' => 'text-rose-300',
                                    'FINISHED' => 'text-emerald-300',
                                    default => 'text-slate-300',
                                };
                            @endphp
                            <article class="ls-panel p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-[11px] uppercase tracking-[0.2em] text-slate-500">{{ $match['competition'] }}</p>
                                    <span class="text-[11px] font-black uppercase tracking-[0.16em] {{ $statusClass }}">{{ $match['status_label'] }}</span>
                                </div>
                                <div class="mt-6 flex items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm text-slate-400">Home</p>
                                        <p class="truncate text-lg font-bold text-white">{{ $match['home'] }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-slate-700/70 bg-slate-950/80 px-4 py-3 text-center">
                                        <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Score</p>
                                        <p class="mt-1 text-xl font-black text-emerald-300">
                                            @if(!is_null($match['score_home']) && !is_null($match['score_away']))
                                                {{ $match['score_home'] }} - {{ $match['score_away'] }}
                                            @else
                                                -- : --
                                            @endif
                                        </p>
                                    </div>
                                    <div class="min-w-0 text-right">
                                        <p class="truncate text-sm text-slate-400">Away</p>
                                        <p class="truncate text-lg font-bold text-white">{{ $match['away'] }}</p>
                                    </div>
                                </div>
                                <p class="mt-5 text-xs uppercase tracking-[0.16em] text-slate-500">{{ $match['kickoff'] ?? 'TBD' }}</p>
                            </article>
                        @empty
                            <div class="ls-panel p-6 text-slate-400 md:col-span-2 xl:col-span-3">
                                Match feed unavailable for now. Please try again shortly.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="features" class="border-t border-slate-800/60 px-4 py-16 sm:px-6 lg:px-8">
                <div class="mx-auto w-full max-w-[1480px]">
                    <span class="ls-kicker">Features</span>
                    <h2 class="mt-4 text-3xl font-black text-white md:text-4xl">Un cockpit complet pour chaque competition</h2>
                    <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                        <article class="ls-panel p-6">
                            <h3 class="text-lg font-black text-white">Tournament Control</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-400">Créez, éditez et surveillez vos compétitions avec un affichage clair des états et des flux.</p>
                        </article>
                        <article class="ls-panel p-6">
                            <h3 class="text-lg font-black text-white">Participant Ops</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-400">Suivez équipes, joueurs et affectations dans une seule vue structurée.</p>
                        </article>
                        <article class="ls-panel p-6">
                            <h3 class="text-lg font-black text-white">Live Scoring</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-400">Les arbitres poussent les résultats, les dashboards se mettent à jour immédiatement.</p>
                        </article>
                        <article class="ls-panel p-6">
                            <h3 class="text-lg font-black text-white">Standings Engine</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-400">Classements, statuts et performances restent lisibles même à grande échelle.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="how" class="border-t border-slate-800/60 px-4 py-16 sm:px-6 lg:px-8">
                <div class="mx-auto w-full max-w-[1480px]">
                    <div class="grid gap-6 lg:grid-cols-[420px_minmax(0,1fr)]">
                        <div class="ls-panel p-7">
                            <span class="ls-kicker">Workflow</span>
                            <h2 class="mt-4 text-3xl font-black text-white">De la creation au suivi live</h2>
                            <p class="mt-4 text-sm leading-7 text-slate-400">Chaque étape a son espace dédié, avec la même identité visuelle sombre et premium.</p>
                        </div>
                        <div class="grid gap-5 md:grid-cols-3">
                            <div class="ls-panel p-6">
                                <p class="text-sm font-black text-emerald-300">01</p>
                                <h3 class="mt-3 text-xl font-black text-white">Create</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-400">Configurez sport, format, dates et participants.</p>
                            </div>
                            <div class="ls-panel p-6">
                                <p class="text-sm font-black text-emerald-300">02</p>
                                <h3 class="mt-3 text-xl font-black text-white">Operate</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-400">Générez les matchs, assignez les rôles, pilotez les journées.</p>
                            </div>
                            <div class="ls-panel p-6">
                                <p class="text-sm font-black text-emerald-300">03</p>
                                <h3 class="mt-3 text-xl font-black text-white">Broadcast</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-400">Exposez scores publics, classements et tendances visuellement.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="cta" class="border-t border-slate-800/60 px-4 py-16 sm:px-6 lg:px-8">
                <div class="mx-auto w-full max-w-[1480px]">
                    <div class="ls-panel p-8 text-center lg:p-12">
                        <span class="ls-kicker">Ready To Launch</span>
                        <h2 class="mt-5 text-3xl font-black text-white md:text-5xl">Passez a une gestion sportive plus visuelle et plus fluide.</h2>
                        <p class="mx-auto mt-5 max-w-2xl text-sm leading-8 text-slate-400">Unifiez dashboards, formulaires et vues publiques dans une seule expérience moderne.</p>
                        <div class="mt-8 flex flex-wrap justify-center gap-3">
                            @auth
                                <x-ui.button as="a" :href="$dashboardRoute" variant="primary" size="lg">Ouvrir mon dashboard</x-ui.button>
                            @else
                                <x-ui.button as="a" :href="route('register')" variant="primary" size="lg">Créer un compte</x-ui.button>
                                <x-ui.button as="a" :href="route('login')" variant="secondary" size="lg">Se connecter</x-ui.button>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-slate-800/70 px-4 py-8 text-center text-sm text-slate-500 sm:px-6 lg:px-8">
            <div class="mx-auto w-full max-w-[1480px]">© {{ date('Y') }} Logi-Sport. Tous droits réservés.</div>
        </footer>
    </div>

    <script>
        (() => {
            const feedUrl = "{{ route('public.matches.feed') }}";
            const refreshMs = Math.max(10, Number("{{ $matchRefreshSeconds }}")) * 1000;
            const grid = document.getElementById('public-matches-grid');
            const updatedAt = document.getElementById('matches-last-updated');
            const dayButtons = document.querySelectorAll('.js-day-filter');
            let currentDay = "{{ $initialMatchDay }}";

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
                        ? 'js-day-filter rounded-2xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-2 text-xs font-black uppercase tracking-[0.16em] text-emerald-300'
                        : 'js-day-filter rounded-2xl border border-slate-700/80 bg-slate-950/70 px-4 py-2 text-xs font-black uppercase tracking-[0.16em] text-slate-300';
                });
            };

            const renderMatches = (matches) => {
                if (!Array.isArray(matches) || matches.length === 0) {
                    grid.innerHTML = `
                        <div class="ls-panel p-6 text-slate-400 md:col-span-2 xl:col-span-3">
                            No matches found for this range.
                        </div>
                    `;
                    return;
                }

                grid.innerHTML = matches.map((match) => {
                    const score = (match.score_home !== null && match.score_away !== null)
                        ? `${escapeHtml(match.score_home)} - ${escapeHtml(match.score_away)}`
                        : '-- : --';

                    const statusClass = (match.status === 'IN_PLAY' || match.status === 'LIVE')
                        ? 'text-rose-300'
                        : (match.status === 'FINISHED' ? 'text-emerald-300' : 'text-slate-300');

                    return `
                        <article class="ls-panel p-5">
                            <div class="flex items-center justify-between gap-3">
                                <p class="truncate text-[11px] uppercase tracking-[0.2em] text-slate-500">${escapeHtml(match.competition)}</p>
                                <span class="text-[11px] font-black uppercase tracking-[0.16em] ${statusClass}">${escapeHtml(match.status_label)}</span>
                            </div>
                            <div class="mt-6 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="truncate text-sm text-slate-400">Home</p>
                                    <p class="truncate text-lg font-bold text-white">${escapeHtml(match.home)}</p>
                                </div>
                                <div class="rounded-2xl border border-slate-700/70 bg-slate-950/80 px-4 py-3 text-center">
                                    <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Score</p>
                                    <p class="mt-1 text-xl font-black text-emerald-300">${score}</p>
                                </div>
                                <div class="min-w-0 text-right">
                                    <p class="truncate text-sm text-slate-400">Away</p>
                                    <p class="truncate text-lg font-bold text-white">${escapeHtml(match.away)}</p>
                                </div>
                            </div>
                            <p class="mt-5 text-xs uppercase tracking-[0.16em] text-slate-500">${escapeHtml(match.kickoff ?? 'TBD')}</p>
                        </article>
                    `;
                }).join('');
            };

            const fetchMatches = async (day = currentDay) => {
                try {
                    const response = await fetch(`${feedUrl}?day=${encodeURIComponent(day)}`, {
                        headers: { Accept: 'application/json' },
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
