<x-app-layout>
    <x-slot name="title">Users Management</x-slot>
    <x-slot name="subtitle">Manage all platform users.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="rounded-2xl border border-green-100 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400">
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
                                <td class="p-6 font-semibold">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="ml-2 text-xs font-bold uppercase tracking-[0.15em] text-blue-600">(You)</span>
                                    @endif
                                </td>

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

                                        <button type="submit" class="rounded-xl bg-blue-50 px-3 py-2 text-sm text-blue-600">
                                            Save
                                        </button>
                                    </form>
                                </td>

                                <td class="p-6">
                                    @if($user->is_active)
                                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-600">
                                            Active
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600">
                                            Suspended
                                        </span>
                                    @endif
                                </td>

                                <td class="p-6">
                                    <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            @disabled($user->id === auth()->id())
                                            class="rounded-xl px-3 py-2 text-sm {{ $user->is_active ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }} {{ $user->id === auth()->id() ? 'cursor-not-allowed opacity-50' : '' }}"
                                        >
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