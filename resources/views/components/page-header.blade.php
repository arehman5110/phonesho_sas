{{-- ============================================================ --}}
{{-- Reusable Page Header with Breadcrumb                        --}}
{{-- Usage:                                                      --}}
{{-- <x-page-header                                              --}}
{{--     title="Create Repair"                                   --}}
{{--     subtitle="Fill in details to create a repair"           --}}
{{--     :breadcrumbs="[                                         --}}
{{--         ['label' => 'Dashboard', 'route' => 'dashboard'],   --}}
{{--         ['label' => 'Repairs',   'route' => 'repairs.index'],--}}
{{--         ['label' => 'Create'],                              --}}
{{--     ]"                                                      --}}
{{-- >                                                           --}}
{{--     <x-slot name="actions">                                 --}}
{{--         ...buttons...                                       --}}
{{--     </x-slot>                                               --}}
{{-- </x-page-header>                                            --}}
{{-- ============================================================ --}}
@props([
    'title'       => '',
    'subtitle'    => '',
    'breadcrumbs' => [],
])

<div class="mb-6">

    {{-- Breadcrumb --}}
    @if(count($breadcrumbs) > 0)
    <nav class="flex items-center gap-1.5 text-xs mb-3 flex-wrap">
        @foreach($breadcrumbs as $index => $crumb)

            @if($index > 0)
                <svg class="w-3 h-3 text-gray-300 dark:text-gray-600 flex-shrink-0"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            @endif

            @if(isset($crumb['route']))
                <a href="{{ route($crumb['route'], $crumb['params'] ?? []) }}"
                   class="text-gray-400 hover:text-indigo-600
                          dark:text-gray-500 dark:hover:text-indigo-400
                          transition-colors font-medium">
                    {{ $crumb['label'] }}
                </a>
            @else
                <span class="text-gray-700 dark:text-gray-300 font-semibold">
                    {{ $crumb['label'] }}
                </span>
            @endif

        @endforeach
    </nav>
    @endif

    {{-- Title Row --}}
    <div class="flex flex-col sm:flex-row sm:items-center
                justify-between gap-4">

        {{-- Title + Subtitle --}}
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white
                       leading-tight">
                {{ $title }}
            </h1>
            @if($subtitle)
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                {{ $subtitle }}
            </p>
            @endif
        </div>

        {{-- Actions Slot --}}
        @isset($actions)
        <div class="flex items-center gap-3 flex-shrink-0">
            {{ $actions }}
        </div>
        @endisset

    </div>

</div>