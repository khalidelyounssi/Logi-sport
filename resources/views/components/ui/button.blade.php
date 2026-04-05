@props([
    'as' => 'button',
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $variantClasses = match ($variant) {
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm',
        'secondary' => 'bg-slate-100 text-slate-700 hover:bg-slate-200',
        'dark' => 'bg-slate-900 text-white hover:bg-slate-800 shadow-sm',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm',
        'danger-soft' => 'bg-red-50 text-red-600 hover:bg-red-100',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100',
        default => 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm',
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
