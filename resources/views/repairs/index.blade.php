<x-app-layout>
<x-slot name="title">Repairs</x-slot>

@push('styles')
<style>
    /* ── Expand animation ────────────────────────── */
    .repair-expand {
        display: none;
    }
    .repair-expand.open {
        display: table-row;
        animation: fadeIn 0.2s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    /* ── Status dropdown ─────────────────────────── */
    .status-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        transition: background 0.1s;
        border-radius: 8px;
        margin: 2px 4px;
    }
    .status-option:hover {
        background: #f1f5f9;
    }
    .dark .status-option:hover {
        background: #1e293b;
    }
    .status-option.selected {
        background: #eef2ff;
    }
    .dark .status-option.selected {
        background: #1e1b4b;
    }

    /* ── Badge colors ────────────────────────────── */
    .badge-green  { background:#dcfce7;color:#166534; }
    .badge-blue   { background:#dbeafe;color:#1e40af; }
    .badge-yellow { background:#fef9c3;color:#713f12; }
    .badge-orange { background:#ffedd5;color:#9a3412; }
    .badge-red    { background:#fee2e2;color:#991b1b; }
    .badge-purple { background:#f3e8ff;color:#6b21a8; }
    .badge-gray   { background:#f1f5f9;color:#475569; }
    .dark .badge-green  { background:#14532d;color:#86efac; }
    .dark .badge-blue   { background:#1e3a8a;color:#93c5fd; }
    .dark .badge-yellow { background:#713f12;color:#fde68a; }
    .dark .badge-orange { background:#7c2d12;color:#fdba74; }
    .dark .badge-red    { background:#7f1d1d;color:#fca5a5; }
    .dark .badge-purple { background:#4a1d96;color:#d8b4fe; }
    .dark .badge-gray   { background:#1e293b;color:#94a3b8; }

    /* ── Repair row ──────────────────────────────── */
    .repair-row {
        cursor: pointer;
        transition: background 0.1s;
    }

    /* ── Active filter tag ───────────────────────── */
    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        background: #eef2ff;
        color: #4338ca;
        border: 1px solid #c7d2fe;
    }
    .dark .filter-tag {
        background: #1e1b4b;
        color: #a5b4fc;
        border-color: #3730a3;
    }
</style>
@endpush

{{-- ── Page Header ─────────────────────────────── --}}
<x-page-header
    title="Repairs"
    subtitle="Manage and track all repair jobs"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Repairs'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('repairs.create') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Repair
        </a>
    </x-slot>
</x-page-header>

{{-- ── Flash Message ────────────────────────────── --}}
@if(session('success'))
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     x-transition
     class="flex items-center gap-3 px-4 py-3 rounded-xl mb-5
            bg-green-50 dark:bg-green-900/20
            border border-green-200 dark:border-green-800
            text-green-800 dark:text-green-300 text-sm font-semibold">
    <svg class="w-5 h-5 flex-shrink-0 text-green-500" fill="none"
         stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
    <button @click="show = false"
            class="ml-auto bg-transparent border-none cursor-pointer
                   text-green-600 p-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- ── Filters Card ─────────────────────────────── --}}
<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl p-4 mb-4">

    {{-- Row 1: Search + Status + Dates --}}
    <div class="flex flex-wrap gap-3 items-end">

        {{-- Search --}}
        <div class="flex-1 min-w-48 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2
                        w-4 h-4 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text"
                   id="filter-search"
                   placeholder="Reference, customer, device, IMEI..."
                   value="{{ request('search') }}"
                   class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          placeholder-gray-400 dark:placeholder-gray-500
                          focus:border-indigo-500
                          focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900
                          transition-all">
        </div>

        {{-- Status Multi-Select Dropdown --}}
        <div class="relative" id="status-dropdown-wrap">
            <button type="button"
                    id="status-dropdown-btn"
                    onclick="RepairIndex.toggleStatusDropdown()"
                    class="flex items-center gap-2 px-4 py-2.5
                           border border-gray-200 dark:border-gray-700
                           rounded-xl text-sm font-semibold
                           bg-gray-50 dark:bg-gray-800
                           text-gray-700 dark:text-gray-300
                           hover:border-indigo-400 hover:bg-white
                           dark:hover:bg-gray-900 transition-all
                           min-w-40 justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0
                                 01-.293.707L13 13.414V19a1 1 0 01-.553.894
                                 l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1
                                 1 0 013 6V4z"/>
                    </svg>
                    <span id="status-btn-label">All Statuses</span>
                </div>
                <svg class="w-3.5 h-3.5 text-gray-400 transition-transform"
                     id="status-chevron"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown Panel --}}
            <div id="status-dropdown-panel"
                 style="display:none;position:absolute;top:calc(100% + 6px);
                        left:0;z-index:100;min-width:220px;
                        background:#fff;border-radius:14px;
                        border:1.5px solid #e2e8f0;
                        box-shadow:0 8px 24px rgba(0,0,0,0.12);
                        padding:8px 0;"
                 class="dark:bg-gray-900 dark:border-gray-700">

                {{-- Select All / None --}}
                <div class="flex items-center justify-between
                            px-4 py-2 border-b border-gray-100
                            dark:border-gray-800 mb-1">
                    <span class="text-xs font-bold text-gray-400
                                 dark:text-gray-500 uppercase tracking-wider">
                        Status
                    </span>
                    <div class="flex gap-3">
                        <button type="button"
                                onclick="RepairIndex.selectAllStatuses()"
                                class="text-xs font-semibold text-indigo-500
                                       hover:text-indigo-700 border-none
                                       bg-transparent cursor-pointer p-0">
                            All
                        </button>
                        <button type="button"
                                onclick="RepairIndex.clearAllStatuses()"
                                class="text-xs font-semibold text-gray-400
                                       hover:text-red-500 border-none
                                       bg-transparent cursor-pointer p-0">
                            None
                        </button>
                    </div>
                </div>

                {{-- Status Options --}}
                @foreach($statuses as $status)
                @php
                    $dotColors = [
                        'green'  => '#10b981',
                        'blue'   => '#3b82f6',
                        'yellow' => '#f59e0b',
                        'orange' => '#f97316',
                        'red'    => '#ef4444',
                        'purple' => '#8b5cf6',
                        'gray'   => '#6b7280',
                    ];
                    $dotColor = $dotColors[$status->color] ?? '#6b7280';
                @endphp
                <div class="status-option selected"
                     data-status-id="{{ $status->id }}"
                     data-status-name="{{ $status->name }}"
                     data-status-color="{{ $status->color }}"
                     onclick="RepairIndex.toggleStatus({{ $status->id }}, this)">
                    {{-- Checkbox --}}
                    <div class="w-4 h-4 rounded flex items-center
                                justify-center border-2 flex-shrink-0
                                transition-all"
                         id="status-check-{{ $status->id }}"
                         style="border-color:{{ $dotColor }};
                                background:{{ $dotColor }};">
                        <svg class="w-2.5 h-2.5 text-white" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span style="color:{{ $dotColor }};">
                        {{ $status->name }}
                    </span>
                </div>
                @endforeach

            </div>
        </div>

        {{-- Date From --}}
        <div class="flex items-center gap-2">
            <label class="text-xs font-semibold text-gray-500
                           dark:text-gray-400 whitespace-nowrap">
                From
            </label>
            <input type="date"
                   id="filter-date-from"
                   value="{{ request('date_from') }}"
                   class="px-3 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 transition-all">
        </div>

        {{-- Date To --}}
        <div class="flex items-center gap-2">
            <label class="text-xs font-semibold text-gray-500
                           dark:text-gray-400 whitespace-nowrap">
                To
            </label>
            <input type="date"
                   id="filter-date-to"
                   value="{{ request('date_to') }}"
                   class="px-3 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 transition-all">
        </div>

    </div>

   

</div>
{{-- ── Active Filter Tags ──────────────────────── --}}
<div id="active-filters-wrapper"
     style="display:none;"
     class="flex items-center gap-2 flex-wrap mb-3 px-1">

    <span class="text-xs font-bold text-gray-400 dark:text-gray-500
                 uppercase tracking-wider whitespace-nowrap">
        Showing:
    </span>

    <div id="active-filters"
         class="flex items-center gap-2 flex-wrap flex-1">
    </div>

</div>
{{-- ── Results Info --}}
<div class="flex items-center justify-between mb-3 px-1">
    <p id="results-info"
       class="text-sm text-gray-500 dark:text-gray-400">
        Showing {{ $repairs->firstItem() ?? 0 }}–{{ $repairs->lastItem() ?? 0 }}
        of {{ $repairs->total() }} repairs
    </p>
    <div id="loading-indicator"
         style="display:none;"
         class="flex items-center gap-2 text-sm
                text-indigo-500 dark:text-indigo-400 font-semibold">
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        Loading...
    </div>
</div>

{{-- ── Table ────────────────────────────────────── --}}
<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full" id="repairs-table">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <th class="w-8 px-4 py-3"></th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Ref / Date
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Customer
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider hidden sm:table-cell">
                        Devices
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider hidden md:table-cell">
                        Status
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider hidden lg:table-cell">
                        Total
                    </th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody id="repairs-tbody"
                   class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($repairs as $repair)
                    @include('repairs.partials.index-row', compact('repair'))
                @empty
                    @include('repairs.partials.index-empty')
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div id="pagination-wrapper"
         class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $repairs->links() }}
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/repair-index.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    RepairIndex.init({
        fetchUrl : '{{ route("repairs.index") }}',
        csrf     : '{{ csrf_token() }}',
    });
});
</script>
@endpush

</x-app-layout>