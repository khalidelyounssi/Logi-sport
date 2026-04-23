<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="subtitle">Your workspace is ready.</x-slot>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1.2fr)_380px]">
        <x-ui.card padding="p-8">
            <span class="ls-kicker">System Ready</span>
            <h2 class="mt-5 text-3xl font-black text-white">You are logged in successfully.</h2>
            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-400">
                Your workspace is active and styled as a unified control center. Use the navigation modules to jump into tournaments, matches, participants, and standings.
            </p>
        </x-ui.card>

        <x-ui.card>
            <p class="ls-stat-label">Workspace Status</p>
            <p class="ls-stat-value">Online</p>
            <p class="mt-3 text-sm text-slate-400">All navigation and dashboard panels are ready to use.</p>
        </x-ui.card>
    </div>
</x-app-layout>
