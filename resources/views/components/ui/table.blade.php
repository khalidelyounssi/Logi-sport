@props([
    'compact' => false,
])

<div {{ $attributes->class('overflow-x-auto rounded-[26px]') }}>
    <table class="min-w-full text-left text-sm text-slate-200">
        {{ $slot }}
    </table>
</div>
