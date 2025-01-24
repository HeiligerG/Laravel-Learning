@props(['type' => 'success', 'message'])

@php
$styles = [
'success' => [
'wrapper' => 'bg-emerald-500/10 border-emerald-500/20',
'text' => 'text-emerald-400',
'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
],
'error' => [
'wrapper' => 'bg-red-500/10 border-red-500/20',
'text' => 'text-red-400',
'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
],
'warning' => [
'wrapper' => 'bg-amber-500/10 border-amber-500/20',
'text' => 'text-amber-400',
'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z'
],
'info' => [
'wrapper' => 'bg-brandIndigo/10 border-brandIndigo/20',
'text' => 'text-brandIndigo',
'icon' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z'
]
];
@endphp

<div x-data="{ show: true }"
     x-show="show"
     x-transition.duration.300ms
     class="rounded-lg border p-4 {{ $styles[$type]['wrapper'] }}">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0 {{ $styles[$type]['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $styles[$type]['icon'] }}"/>
        </svg>
        <p class="text-sm font-medium {{ $styles[$type]['text'] }}">{{ $message }}</p>
        <button @click="show = false" class="ml-auto">
            <svg class="w-4 h-4 {{ $styles[$type]['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
