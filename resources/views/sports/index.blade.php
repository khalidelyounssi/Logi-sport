@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-100">Sports Management</h1>
                <p class="text-slate-400 mt-2">Manage all sports in the system</p>
            </div>
            <a href="{{ route('sports.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition">
                + Add Sport
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if ($message = Session::get('success'))
            <div class="mb-6 p-4 bg-emerald-900/30 border border-emerald-500/50 rounded-lg text-emerald-300">
                {{ $message }}
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="mb-6 p-4 bg-red-900/30 border border-red-500/50 rounded-lg text-red-300">
                {{ $message }}
            </div>
        @endif

        <!-- Sports Table -->
        <div class="bg-slate-900 rounded-xl border border-slate-800 overflow-hidden">
            @if ($sports->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-800 bg-slate-800/50">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Win Points</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Draw Points</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Result Unit</th>
                                <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sports as $sport)
                                <tr class="border-b border-slate-800 hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4 text-slate-100">{{ $sport->name }}</td>
                                    <td class="px-6 py-4 text-slate-300">{{ $sport->win_points }}</td>
                                    <td class="px-6 py-4 text-slate-300">{{ $sport->draw_points }}</td>
                                    <td class="px-6 py-4 text-slate-300">{{ $sport->result_unit ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right space-x-2 flex justify-end">
                                        <a href="{{ route('sports.edit', $sport) }}" class="px-3 py-1 bg-cyan-600/20 hover:bg-cyan-600/30 text-cyan-300 rounded text-sm transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('sports.destroy', $sport) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-600/20 hover:bg-red-600/30 text-red-300 rounded text-sm transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($sports->hasPages())
                    <div class="px-6 py-4 border-t border-slate-800">
                        {{ $sports->links('pagination::tailwind') }}
                    </div>
                @endif
            @else
                <div class="px-6 py-12 text-center">
                    <p class="text-slate-400 mb-4">No sports found</p>
                    <a href="{{ route('sports.create') }}" class="inline-block px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition">
                        Create First Sport
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
