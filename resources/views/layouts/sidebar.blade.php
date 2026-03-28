@php
    $role = auth()->user()->role;
@endphp

<aside class="hidden lg:flex lg:flex-col w-72 min-h-screen bg-white border-r border-slate-200 px-6 py-8">
    <div class="flex items-center gap-3 mb-10">
        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4m-7-8V7a2 2 0 012-2h2l1-2h4l1 2h2a2 2 0 012 2v6a4 4 0 01-4 4H12a4 4 0 01-4-4z"/>
            </svg>
        </div>

        <div>
            <h1 class="text-3xl font-black italic text-blue-600 leading-none">Logi-Sport</h1>
            <p class="text-xs tracking-[0.2em] text-slate-400 uppercase">Tournament Pro</p>
        </div>
    </div>

    <nav class="space-y-3">
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                <span>📊</span><span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>👥</span><span>Users</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>🏅</span><span>Sports</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>📈</span><span>Statistics</span>
            </a>
        @endif

        @if($role === 'organizer')
            <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('organizer.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                <span>📊</span><span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>🏆</span><span>Tournaments</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>🧩</span><span>Brackets</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>👥</span><span>Teams</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>💰</span><span>Financials</span>
            </a>
        @endif

        @if($role === 'referee')
            <a href="{{ route('referee.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('referee.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                <span>📊</span><span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>⚽</span><span>My Matches</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>📝</span><span>Scores</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>📅</span><span>Schedule</span>
            </a>
        @endif

        @if($role === 'player')
            <a href="{{ route('player.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('player.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                <span>📊</span><span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>🏆</span><span>Tournaments</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>📈</span><span>My Stats</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
                <span>🎯</span><span>My Matches</span>
            </a>
        @endif
    </nav>

    <div class="mt-auto space-y-3 pt-10">
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50">
            <span>❓</span><span>Support</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-red-50 hover:text-red-500 transition">
                <span>↩</span><span>Logout</span>
            </button>
        </form>
    </div>
</aside>