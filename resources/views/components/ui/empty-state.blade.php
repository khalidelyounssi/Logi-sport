@props([
    'title' => 'No data found',
    'description' => 'There is nothing to display yet.',
])

<div {{ $attributes->class('rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center') }}>
    <p class="text-lg font-bold text-slate-800">{{ $title }}</p>
    <p class="mt-2 text-sm text-slate-500">{{ $description }}</p>
    @if(trim($slot) !== '')
        <div class="mt-4 flex items-center justify-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
