@props([
    'padding' => 'p-6',
])

<div {{ $attributes->class("rounded-2xl border border-slate-800 bg-slate-900/75 shadow-sm {$padding}") }}>
    {{ $slot }}
</div>
