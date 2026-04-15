{{-- ============================================================ --}}
{{-- Reusable Form Section Card                                  --}}
{{-- Usage:                                                      --}}
{{-- <x-form-section title="Customer" color="blue">             --}}
{{--     <x-slot name="icon">...svg...</x-slot>                  --}}
{{--     ...content...                                           --}}
{{-- </x-form-section>                                           --}}
{{-- ============================================================ --}}
@props([
    'title'  => '',
    'color'  => 'indigo',
    'badge'  => null,
])

@php
$colors = [
    'blue'    => ['bg' => 'bg-blue-100 dark:bg-blue-900/40',    'text' => 'text-blue-600 dark:text-blue-400'],
    'indigo'  => ['bg' => 'bg-indigo-100 dark:bg-indigo-900/40','text' => 'text-indigo-600 dark:text-indigo-400'],
    'green'   => ['bg' => 'bg-green-100 dark:bg-green-900/40',  'text' => 'text-green-600 dark:text-green-400'],
    'purple'  => ['bg' => 'bg-purple-100 dark:bg-purple-900/40','text' => 'text-purple-600 dark:text-purple-400'],
    'amber'   => ['bg' => 'bg-amber-100 dark:bg-amber-900/40',  'text' => 'text-amber-600 dark:text-amber-400'],
    'red'     => ['bg' => 'bg-red-100 dark:bg-red-900/40',      'text' => 'text-red-600 dark:text-red-400'],
    'emerald' => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/40','text'=> 'text-emerald-600 dark:text-emerald-400'],
    'gray'    => ['bg' => 'bg-gray-100 dark:bg-gray-800',       'text' => 'text-gray-600 dark:text-gray-400'],
];
$c = $colors[$color] ?? $colors['indigo'];
@endphp

<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl">

    {{-- Header --}}
    <div class="flex items-center gap-3 px-5 py-3.5
                bg-gray-50 dark:bg-gray-800
                border-b border-gray-200 dark:border-gray-700">

        {{-- Icon Slot --}}
        @isset($icon)
        <div class="w-7 h-7 rounded-lg {{ $c['bg'] }}
                    flex items-center justify-center flex-shrink-0">
            <span class="{{ $c['text'] }} flex items-center justify-center">
                {{ $icon }}
            </span>
        </div>
        @endisset

        {{-- Title --}}
        <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
            {{ $title }}
        </span>

        {{-- Static Badge --}}
        @if($badge)
        <span class="ml-1 text-xs font-bold px-2 py-0.5 rounded-full
                     {{ $c['bg'] }} {{ $c['text'] }}">
            {{ $badge }}
        </span>
        @endif

        {{-- Dynamic Badge Slot --}}
        @isset($badgeSlot)
        <div class="ml-1">{{ $badgeSlot }}</div>
        @endisset

        {{-- Action Slot --}}
        @isset($actionSlot)
        <div class="ml-auto">{{ $actionSlot }}</div>
        @endisset

    </div>

    {{-- Body --}}
    <div class="p-5">
        {{ $slot }}
    </div>

</div>