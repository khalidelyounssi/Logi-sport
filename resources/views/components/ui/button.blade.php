@props([
    'as' => 'button',
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $variantClasses = match ($variant) {
        'primary' => 'border border-emerald-300/20 bg-emerald-400 text-slate-950 shadow-[0_18px_40px_rgba(53,224,161,0.25)] hover:bg-emerald-300',
        'secondary' => 'border border-slate-700/80 bg-slate-900/80 text-slate-100 hover:border-slate-500 hover:bg-slate-800/90',
        'dark' => 'border border-slate-700/80 bg-slate-950/90 text-white hover:bg-slate-900',
        'success' => 'border border-emerald-400/30 bg-emerald-500/20 text-emerald-200 hover:bg-emerald-500/30',
        'danger' => 'border border-rose-400/30 bg-rose-500 text-white hover:bg-rose-400',
        'danger-soft' => 'border border-rose-400/25 bg-rose-500/10 text-rose-200 hover:bg-rose-500/20',
        'ghost' => 'border border-transparent bg-transparent text-slate-300 hover:border-slate-700/70 hover:bg-slate-900/70 hover:text-white',
        default => 'border border-emerald-300/20 bg-emerald-400 text-slate-950 shadow-[0_18px_40px_rgba(53,224,161,0.25)] hover:bg-emerald-300',
    };

    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-2 text-xs rounded-xl',
        'lg' => 'px-6 py-3.5 text-sm rounded-2xl',
        default => 'px-4 py-2.5 text-sm rounded-2xl',
    };

    $classes = "inline-flex items-center justify-center gap-2 font-semibold transition duration-200 {$variantClasses} {$sizeClasses}";
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
