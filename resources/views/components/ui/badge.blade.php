@props([
    'variant' => 'slate',
    'status' => null,
])

@php
    $resolved = strtolower($status ?? $variant);

    $classes = match ($resolved) {
        'success', 'finished', 'completed', 'active' => 'bg-emerald-500/15 text-emerald-300 border border-emerald-400/30',
        'warning', 'in_progress', 'upcoming', 'live' => 'bg-amber-500/15 text-amber-300 border border-amber-400/30',
        'danger', 'inactive', 'cancelled' => 'bg-rose-500/15 text-rose-300 border border-rose-400/30',
        'info', 'scheduled', 'draft' => 'bg-cyan-500/15 text-cyan-300 border border-cyan-400/30',
        default => 'bg-slate-700/40 text-slate-200 border border-slate-600',
    };
@endphp

<span {{ $attributes->class("inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold uppercase tracking-wide {$classes}") }}>
    {{ $slot }}
</span>
