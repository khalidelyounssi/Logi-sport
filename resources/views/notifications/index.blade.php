<x-app-layout>
    <x-slot name="title">Notifications</x-slot>
    <x-slot name="subtitle">All your updates and alerts in one place</x-slot>

    <div class="space-y-6">
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-emerald-400">
                    Mark all as read
                </button>
            </form>
        </div>

        <x-ui.card>
            @if($notifications->isEmpty())
                <x-ui.empty-state title="No notifications" description="You will see match, tournament, and player alerts here." />
            @else
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="flex flex-col gap-3 rounded-2xl border {{ $notification->is_read ? 'border-slate-800 bg-slate-900/60' : 'border-emerald-500/30 bg-emerald-500/10' }} p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold text-slate-100">{{ $notification->message }}</span>
                                    @if(!$notification->is_read)
                                        <span class="rounded-full bg-emerald-500 px-2 py-0.5 text-[10px] font-black uppercase tracking-[0.18em] text-slate-950">New</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex items-center gap-2">
                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="rounded-xl border border-slate-700 px-3 py-2 text-xs font-semibold text-slate-200 transition hover:bg-slate-800">Mark as read</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('notifications.destroy', $notification) }}" onsubmit="return confirm('Delete this notification?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-xl border border-red-500/30 px-3 py-2 text-xs font-semibold text-red-300 transition hover:bg-red-500/10">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>
</x-app-layout>
