@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('sports.index') }}" class="text-emerald-400 hover:text-emerald-300 mb-4 inline-flex items-center">
                ← Back to Sports
            </a>
            <h1 class="text-3xl font-bold text-slate-100">Create New Sport</h1>
            <p class="text-slate-400 mt-2">Add a new sport to the system</p>
        </div>

        <!-- Form -->
        <div class="bg-slate-900 rounded-xl border border-slate-800 p-8">
            <form action="{{ route('sports.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-slate-300 mb-2">Sport Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g., Football, Tennis, Basketball"
                        class="w-full px-4 py-2 bg-slate-800 border rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 @error('name') border-red-500 @else border-slate-700 @enderror focus:border-emerald-500 focus:ring-emerald-500">
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Win Points -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="win_points" class="block text-sm font-semibold text-slate-300 mb-2">Win Points</label>
                        <input type="number" id="win_points" name="win_points" value="{{ old('win_points', 3) }}" min="0"
                            class="w-full px-4 py-2 bg-slate-800 border rounded-lg text-slate-100 focus:outline-none focus:ring-1 @error('win_points') border-red-500 @else border-slate-700 @enderror focus:border-emerald-500 focus:ring-emerald-500">
                        @error('win_points')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Draw Points -->
                    <div>
                        <label for="draw_points" class="block text-sm font-semibold text-slate-300 mb-2">Draw Points</label>
                        <input type="number" id="draw_points" name="draw_points" value="{{ old('draw_points', 1) }}" min="0"
                            class="w-full px-4 py-2 bg-slate-800 border rounded-lg text-slate-100 focus:outline-none focus:ring-1 @error('draw_points') border-red-500 @else border-slate-700 @enderror focus:border-emerald-500 focus:ring-emerald-500">
                        @error('draw_points')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Result Unit -->
                <div class="mb-6">
                    <label for="result_unit" class="block text-sm font-semibold text-slate-300 mb-2">Result Unit (optional)</label>
                    <input type="text" id="result_unit" name="result_unit" value="{{ old('result_unit') }}" placeholder="e.g., goal, point, set"
                        class="w-full px-4 py-2 bg-slate-800 border rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 @error('result_unit') border-red-500 @else border-slate-700 @enderror focus:border-emerald-500 focus:ring-emerald-500">
                    @error('result_unit')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ranking Order -->
                <div class="mb-6">
                    <label for="ranking_order" class="block text-sm font-semibold text-slate-300 mb-2">Ranking Order (optional)</label>
                    <input type="text" id="ranking_order" name="ranking_order" value="{{ old('ranking_order') }}" placeholder="e.g., points, wins"
                        class="w-full px-4 py-2 bg-slate-800 border rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 @error('ranking_order') border-red-500 @else border-slate-700 @enderror focus:border-emerald-500 focus:ring-emerald-500">
                    @error('ranking_order')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rules -->
                <div class="mb-6">
                    <label for="rules" class="block text-sm font-semibold text-slate-300 mb-2">Rules (optional)</label>
                    <textarea id="rules" name="rules" rows="4" placeholder="Enter sport rules or description..."
                        class="w-full px-4 py-2 bg-slate-800 border rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 @error('rules') border-red-500 @else border-slate-700 @enderror focus:border-emerald-500 focus:ring-emerald-500">{{ old('rules') }}</textarea>
                    @error('rules')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition">
                        Create Sport
                    </button>
                    <a href="{{ route('sports.index') }}" class="flex-1 px-6 py-2 bg-slate-700 hover:bg-slate-600 text-slate-100 rounded-lg font-medium text-center transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
