@props([
    'padding' => 'p-6',
])

<div {{ $attributes->class("ls-panel {$padding}") }}>
    {{ $slot }}
</div>
