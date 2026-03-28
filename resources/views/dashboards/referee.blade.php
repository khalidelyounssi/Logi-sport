<x-app-layout>
    <x-slot name="title">Match Scoring</x-slot>
    <x-slot name="subtitle">Update live scores and confirm the final result.</x-slot>

    <div class="space-y-8">
        <div class="bg-[#eef2ff] rounded-[2rem] p-8 border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4 text-lg">
                    <span class="text-orange-600 font-bold">● IN PROGRESS</span>
                    <span class="text-slate-500">Second Half (62:14)</span>
                </div>
                <div class="px-4 py-2 rounded-full bg-orange-50 text-orange-600 font-semibold text-sm">
                    LIVE - Stadium A
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <div class="bg-white rounded-[2rem] p-8 text-center shadow-sm">
                    <h3 class="text-4xl font-black mb-3">Red Hawks FC</h3>
                    <p class="text-slate-400 uppercase tracking-[0.2em] text-sm mb-8">Home Team</p>
                    <div class="flex items-center justify-center gap-8">
                        <button class="w-16 h-16 rounded-full border border-blue-200 text-3xl text-blue-600">−</button>
                        <span class="text-8xl font-black text-blue-600">2</span>
                        <button class="w-16 h-16 rounded-full bg-blue-600 text-white text-3xl shadow-lg">+</button>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] p-8 text-center shadow-sm">
                    <h3 class="text-4xl font-black mb-3">Blue Waves United</h3>
                    <p class="text-slate-400 uppercase tracking-[0.2em] text-sm mb-8">Away Team</p>
                    <div class="flex items-center justify-center gap-8">
                        <button class="w-16 h-16 rounded-full border border-blue-200 text-3xl text-blue-600">−</button>
                        <span class="text-8xl font-black text-slate-900">1</span>
                        <button class="w-16 h-16 rounded-full bg-blue-600 text-white text-3xl shadow-lg">+</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm">
                <h3 class="text-xl font-bold mb-5">Quick Events</h3>
                <div class="grid grid-cols-2 gap-4">
                    <button class="rounded-2xl bg-slate-50 p-6 font-semibold">🟨 Yellow Card</button>
                    <button class="rounded-2xl bg-slate-50 p-6 font-semibold">🟥 Red Card</button>
                    <button class="rounded-2xl bg-slate-50 p-6 font-semibold">🔁 Sub In</button>
                    <button class="rounded-2xl bg-slate-50 p-6 font-semibold">🩹 Injury</button>
                </div>
            </div>

            <div class="xl:col-span-2 bg-white rounded-[2rem] p-6 shadow-sm">
                <h3 class="text-xl font-bold mb-5">Active Rosters</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-4">
                        <div>
                            <p class="font-semibold">Marcus Sterling</p>
                            <p class="text-sm text-slate-500">Forward / Captain</p>
                        </div>
                        <span class="text-orange-500 font-bold">⚽ 1</span>
                    </div>
                    <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-4">
                        <div>
                            <p class="font-semibold">Luca Rossi</p>
                            <p class="text-sm text-slate-500">Midfield</p>
                        </div>
                        <span class="text-blue-600 font-bold">🅰 2</span>
                    </div>
                </div>

                <div class="mt-6">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-semibold shadow-lg">
                        Submit Final Score
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>