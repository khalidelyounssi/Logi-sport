<x-app-layout>
    <x-slot name="title">Player Dashboard</x-slot>
    <x-slot name="subtitle">Track your tournaments and performance.</x-slot>

    <div class="space-y-8">

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <x-stat-card title="Matches Played" value="18" />
            <x-stat-card title="Goals" value="12" />
            <x-stat-card title="Assists" value="6" />
            <x-stat-card title="Wins" value="10" hint="+3" />
        </div>

        <!-- MY TOURNAMENTS -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold">My Tournaments</h3>
                <a href="#" class="bg-blue-600 text-white px-5 py-3 rounded-2xl font-semibold shadow hover:bg-blue-700">
                    Join Tournament
                </a>
            </div>

            <div class="divide-y">
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-lg">City League</p>
                        <p class="text-sm text-slate-500">Soccer</p>
                    </div>
                    <span class="text-blue-600 font-bold">UPCOMING</span>
                </div>

                <div class="p-6 flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-lg">Summer Cup</p>
                        <p class="text-sm text-slate-500">Basketball</p>
                    </div>
                    <span class="text-green-600 font-bold">ACTIVE</span>
                </div>
            </div>
        </div>

        <!-- PERFORMANCE -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
            <h3 class="text-xl font-bold mb-6">Performance</h3>

            <div class="space-y-4">
                <div class="bg-slate-50 p-4 rounded-2xl flex justify-between">
                    <span>Goals per match</span>
                    <span class="font-bold text-blue-600">0.8</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl flex justify-between">
                    <span>Win rate</span>
                    <span class="font-bold text-green-600">65%</span>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>