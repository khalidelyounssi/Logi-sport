@props([
    'variant' => 'slate',
    'status' => null,
])

@php
    $resolved = strtolower($status ?? $variant);

    $classes = match ($resolved) {
        'success', 'finished', 'completed', 'active' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'warning', 'in_progress', 'upcoming', 'live' => 'bg-amber-50 text-amber-700 border border-amber-200',
        'danger', 'inactive', 'cancelled' => 'bg-red-50 text-red-700 border border-red-200',
        'info', 'scheduled', 'draft' => 'bg-blue-50 text-blue-700 border border-blue-200',
        default => 'bg-slate-100 text-slate-700 border border-slate-200',
    };
@endphp

<span {{ $attributes->class("inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold uppercase tracking-wide {$classes}") }}>
    {{ $slot }}
</span>
