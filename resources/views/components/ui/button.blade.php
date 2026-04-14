@props([
    'as' => 'button',
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $variantClasses = match ($variant) {
        'primary' => 'bg-emerald-500 text-slate-900 hover:bg-emerald-400 shadow-sm',
        'secondary' => 'bg-slate-800 text-slate-100 hover:bg-slate-700 border border-slate-700',
        'dark' => 'bg-slate-900 text-white hover:bg-slate-800 shadow-sm border border-slate-700',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-500 shadow-sm',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-500 shadow-sm',
        'danger-soft' => 'bg-rose-500/10 text-rose-300 hover:bg-rose-500/20 border border-rose-500/30',
        'ghost' => 'bg-transparent text-slate-300 hover:bg-slate-800',
        default => 'bg-emerald-500 text-slate-900 hover:bg-emerald-400 shadow-sm',
    };

    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-2 text-xs rounded-xl',
        'lg' => 'px-6 py-3.5 text-sm rounded-2xl',
        default => 'px-4 py-2.5 text-sm rounded-2xl',
    };

    $classes = "inline-flex items-center justify-center gap-2 font-semibold transition {$variantClasses} {$sizeClasses}";
@endphp

@if($as === 'a')
    <a href="{{ $href ?? '#' }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </button>
@endif
