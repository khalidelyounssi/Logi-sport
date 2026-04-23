<x-app-layout>
    <x-slot name="title">Users Management</x-slot>
    <x-slot name="subtitle">Manage all platform users.</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-rose-400/30 bg-rose-500/10 px-4 py-3 text-rose-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-[2rem] border border-slate-800/80 bg-slate-950/40 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-950/70 text-xs uppercase tracking-[0.2em] text-slate-500">
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
                            <tr class="border-t border-slate-800/80">
                                <td class="p-6 font-semibold">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="ml-2 text-xs font-bold uppercase tracking-[0.15em] text-emerald-300">(You)</span>
                                    @endif
                                </td>

                                <td class="p-6">{{ $user->email }}</td>

                                <td class="p-6">
                                    <form action="{{ route('admin.users.changeRole', $user) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="role" class="ui-select !rounded-xl !py-2 text-sm">
                                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                            <option value="organizer" @selected($user->role === 'organizer')>Organizer</option>
                                            <option value="referee" @selected($user->role === 'referee')>Referee</option>
                                            <option value="player" @selected($user->role === 'player')>Player</option>
                                        </select>

                                        <button type="submit" class="rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-3 py-2 text-sm font-semibold text-emerald-300 transition hover:bg-emerald-400/20">
                                            Save
                                        </button>
                                    </form>
                                </td>

                                <td class="p-6">
                                    @if($user->is_active)
                                        <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-bold text-emerald-300">
                                            Active
                                        </span>
                                    @else
                                        <span class="rounded-full bg-rose-500/10 px-3 py-1 text-xs font-bold text-rose-300">
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
                                            class="rounded-xl px-3 py-2 text-sm font-semibold {{ $user->is_active ? 'bg-rose-500/10 text-rose-300' : 'bg-emerald-500/10 text-emerald-300' }} {{ $user->id === auth()->id() ? 'cursor-not-allowed opacity-50' : '' }}"
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
