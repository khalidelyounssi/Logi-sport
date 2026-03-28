<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="subtitle">Manage platform, users and sports.</x-slot>

    <div class="space-y-8">

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <x-stat-card title="Total Users" value="245" hint="+12%" />
            <x-stat-card title="Total Sports" value="8" />
            <x-stat-card title="Active Tournaments" value="14" />
            <x-stat-card title="Revenue" value="$52k" hint="↗" />
        </div>

        <!-- USERS TABLE -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold">Users Management</h3>
                <a href="#" class="bg-blue-600 text-white px-5 py-3 rounded-2xl font-semibold shadow hover:bg-blue-700">
                    + Add User
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs uppercase text-slate-400 tracking-wider">
                        <tr>
                            <th class="p-6">Name</th>
                            <th class="p-6">Email</th>
                            <th class="p-6">Role</th>
                            <th class="p-6">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-700">
                        <tr class="border-t">
                            <td class="p-6 font-semibold">John Doe</td>
                            <td class="p-6">john@email.com</td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold">Admin</span>
                            </td>
                            <td class="p-6 flex gap-2">
                                <button class="px-4 py-2 rounded-xl bg-slate-100">Edit</button>
                                <button class="px-4 py-2 rounded-xl bg-red-50 text-red-500">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SPORTS -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
            <h3 class="text-xl font-bold mb-6">Sports</h3>

            <div class="flex flex-wrap gap-4">
                <div class="px-5 py-3 rounded-2xl bg-blue-50 text-blue-600 font-semibold">⚽ Soccer</div>
                <div class="px-5 py-3 rounded-2xl bg-orange-50 text-orange-600 font-semibold">🏀 Basketball</div>
                <div class="px-5 py-3 rounded-2xl bg-green-50 text-green-600 font-semibold">🎾 Tennis</div>
            </div>
        </div>

    </div>
</x-app-layout>