@props([
    'title',
    'value',
    'hint' => null,
    'tone' => 'blue',
])

@php
    $toneClasses = match ($tone) {
        'emerald' => 'text-emerald-300',
        'amber' => 'text-amber-300',
        'slate' => 'text-slate-200',
        default => 'text-cyan-300',
    };
@endphp

<x-ui.card>
    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $title }}</p>
    <p class="mt-2 text-3xl font-black {{ $toneClasses }}">{{ $value }}</p>
    @if($hint)
        <p class="mt-1 text-sm text-slate-400">{{ $hint }}</p>
    @endif
</x-ui.card>
