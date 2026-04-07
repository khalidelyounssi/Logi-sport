<x-app-layout>
    <x-slot name="title">Users Management</x-slot>
    <x-slot name="subtitle">Manage all platform users.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-2xl border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 text-red-700 px-4 py-3 rounded-2xl border border-red-100">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs uppercase text-slate-400 tracking-[0.2em] bg-slate-50">
                        <tr>
                            <th class="p-6">Name</th>
                            <th class="p-6">Email</th>
                            <th class="p-6">Role</th>
                            <th class="p-6">Status</th>
                            <th class="p-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-t border-slate-100">
                                <td class="p-6 font-semibold">{{ $user->name }}</td>
                                <td class="p-6">{{ $user->email }}</td>
                                <td class="p-6">
                                    <form action="{{ route('admin.users.changeRole', $user) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="role" class="rounded-xl border-slate-200 text-sm">
                                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                            <option value="organizer" @selected($user->role === 'organizer')>Organizer</option>
                                            <option value="referee" @selected($user->role === 'referee')>Referee</option>
                                            <option value="player" @selected($user->role === 'player')>Player</option>
                                        </select>

                                        <button type="submit" class="px-3 py-2 rounded-xl bg-blue-50 text-blue-600 text-sm">
                                            Save
                                        </button>
                                    </form>
                                </td>
                                <td class="p-6">
                                    @if($user->is_active)
                                        <span class="px-3 py-1 rounded-full bg-green-50 text-green-600 text-xs font-bold">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold">
                                            Suspended
                                        </span>
                                    @endif
                                </td>
                                <td class="p-6">
                                    <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button class="px-3 py-2 rounded-xl text-sm {{ $user->is_active ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                                            {{ $user->is_active ? 'Suspend' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-500">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>