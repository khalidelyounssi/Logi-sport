@props([
    'padding' => 'p-6',
])

<div {{ $attributes->class("rounded-2xl border border-slate-200/80 bg-white shadow-sm {$padding}") }}>
    {{ $slot }}
</div>
