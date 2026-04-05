@props([
    'compact' => false,
])

<div {{ $attributes->class('overflow-x-auto') }}>
    <table class="min-w-full text-left text-sm text-slate-700">
        {{ $slot }}
    </table>
</div>
