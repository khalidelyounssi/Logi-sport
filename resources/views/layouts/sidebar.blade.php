@php
    $role = auth()->user()->role;
@endphp

<aside class="w-64 h-screen bg-white border-r border-slate-200 flex flex-col justify-between">
    <div>
        <div class="px-6 py-6 border-b border-slate-100">
            <h1 class="text-xl font-black text-blue-600">⚽ Logi-Sport</h1>
        </div>

        <nav class="p-4 space-y-2">

            {{-- ADMIN --}}
            @if($role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>

                <a href="#" class="menu-link">
                    👥 Manage Users
                </a>

                <a href="#" class="menu-link">
                    📈 Statistics
                </a>
            @endif

            {{-- ORGANIZER --}}
            @if($role === 'organizer')
                <a href="{{ route('organizer.dashboard') }}" class="menu-link {{ request()->routeIs('organizer.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>

                <a href="{{ route('tournaments.index') }}" class="menu-link {{ request()->routeIs('tournaments.*') ? 'active' : '' }}">
                    🏆 Tournaments
                </a>
            @endif

            {{-- REFEREE --}}
            @if($role === 'referee')
                <a href="{{ route('referee.dashboard') }}" class="menu-link {{ request()->routeIs('referee.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>

                <a href="{{ route('referee.matches.index') }}" class="menu-link {{ request()->routeIs('referee.matches.*') ? 'active' : '' }}">
                    ⚽ My Matches
                </a>
            @endif

            {{-- PLAYER --}}
            @if($role === 'player')
                <a href="{{ route('player.dashboard') }}" class="menu-link {{ request()->routeIs('player.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>

                <a href="#" class="menu-link">
                    🎮 My Tournaments
                </a>
            @endif

        </nav>
    </div>

    <div class="p-4 border-t border-slate-100">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div>
                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400 capitalize">{{ $role }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left text-red-600 text-sm font-semibold hover:underline">
                🚪 Logout
            </button>
        </form>
    </div>
</aside>