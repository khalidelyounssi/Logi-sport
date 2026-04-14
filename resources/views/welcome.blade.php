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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative">
            <div class="max-w-3xl">
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

    <!-- Features -->
    <section id="features" class="py-16 md:py-24 border-t border-slate-800/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
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
</body>
</html>