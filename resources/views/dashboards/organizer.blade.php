<x-app-layout>
    <x-slot name="title">Tournaments</x-slot>
    <x-slot name="subtitle">Manage and monitor your athletic competitions.</x-slot>

    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <div></div>
            <a href="#" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-4 rounded-2xl shadow-lg hover:bg-blue-700 transition font-semibold">
                <span>➕</span>
                <span>Create Tournament</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <x-stat-card title="Live Matches" value="12" hint="LIVE" />
            <x-stat-card title="Total Teams" value="148" hint="+12%" />
            <x-stat-card title="Upcoming" value="06" hint="Next 30 Days" />
            <x-stat-card title="Revenue" value="$24k" hint="↗" />
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex gap-3 text-sm">
                    <button class="px-5 py-3 rounded-2xl bg-blue-50 text-blue-600 font-semibold">All Tournaments</button>
                    <button class="px-5 py-3 rounded-2xl text-slate-500 hover:bg-slate-50">Active</button>
                    <button class="px-5 py-3 rounded-2xl text-slate-500 hover:bg-slate-50">Drafts</button>
                </div>

                <div class="flex gap-3">
                    <input type="text" placeholder="Filter by name..." class="px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm outline-none">
                    <button class="px-4 py-3 rounded-2xl border border-slate-200 bg-white">⬇</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs uppercase tracking-[0.2em] text-slate-400">
                        <tr>
                            <th class="p-6">Tournament Name</th>
                            <th class="p-6">Sport</th>
                            <th class="p-6">Format</th>
                            <th class="p-6">Date</th>
                            <th class="p-6">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-700">
                        <tr class="border-t border-slate-100">
                            <td class="p-6 font-semibold">Metro Elite Basketball Open</td>
                            <td class="p-6"><span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold">Basketball</span></td>
                            <td class="p-6">Direct Elimination</td>
                            <td class="p-6">Oct 12 - Oct 20</td>
                            <td class="p-6 text-orange-500 font-semibold">LIVE</td>
                        </tr>
                        <tr class="border-t border-slate-100">
                            <td class="p-6 font-semibold">Summer Kickoff Classic</td>
                            <td class="p-6"><span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold">Soccer</span></td>
                            <td class="p-6">Round Robin</td>
                            <td class="p-6">Nov 05 - Nov 12</td>
                            <td class="p-6 text-blue-600 font-semibold">UPCOMING</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>