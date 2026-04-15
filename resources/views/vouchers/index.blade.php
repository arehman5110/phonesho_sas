<x-app-layout>
<x-slot name="title">Vouchers</x-slot>

@push('styles')
<style>
    .badge-green  { background:#dcfce7;color:#166534; }
    .badge-red    { background:#fee2e2;color:#991b1b; }
    .badge-orange { background:#ffedd5;color:#9a3412; }
    .badge-gray   { background:#f1f5f9;color:#475569; }
</style>
@endpush

{{-- ── Page Header ─────────────────────────────── --}}
<x-page-header
    title="Vouchers"
    subtitle="Manage discount vouchers and promo codes"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Vouchers'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('vouchers.create') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Voucher
        </a>
    </x-slot>
</x-page-header>

{{-- ── Flash Messages ──────────────────────────── --}}
@if(session('success'))
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 4000)"
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
</div>
@endif

{{-- ── Stats ───────────────────────────────────── --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">

    @foreach([
        ['label' => 'Total',    'value' => $summary['total'],   'color' => 'indigo', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
        ['label' => 'Active',   'value' => $summary['active'],  'color' => 'green',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Expired',  'value' => $summary['expired'], 'color' => 'red',    'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Used Up',  'value' => $summary['usedUp'],  'color' => 'orange', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
    ] as $stat)
    @php
        $bgMap = [
            'indigo' => 'bg-indigo-100 dark:bg-indigo-900/40',
            'green'  => 'bg-green-100 dark:bg-green-900/40',
            'red'    => 'bg-red-100 dark:bg-red-900/40',
            'orange' => 'bg-orange-100 dark:bg-orange-900/40',
        ];
        $textMap = [
            'indigo' => 'text-indigo-600 dark:text-indigo-400',
            'green'  => 'text-green-600 dark:text-green-400',
            'red'    => 'text-red-600 dark:text-red-400',
            'orange' => 'text-orange-600 dark:text-orange-400',
        ];
    @endphp
    <div class="bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl {{ $bgMap[$stat['color']] }}
                    flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 {{ $textMap[$stat['color']] }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="{{ $stat['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500
                       dark:text-gray-400 uppercase tracking-wider">
                {{ $stat['label'] }}
            </p>
            <p class="text-2xl font-black {{ $textMap[$stat['color']] }}">
                {{ $stat['value'] }}
            </p>
        </div>
    </div>
    @endforeach

</div>

{{-- ── Filters ──────────────────────────────────── --}}
<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl p-4 mb-4">
    <form method="GET" action="{{ route('vouchers.index') }}"
          class="flex flex-wrap gap-3 items-end">

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
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search voucher code..."
                   class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 transition-all">
        </div>

        {{-- Status --}}
        <select name="status"
                class="px-3 py-2.5
                       border border-gray-200 dark:border-gray-700
                       rounded-xl text-sm outline-none
                       bg-gray-50 dark:bg-gray-800
                       text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all
                       cursor-pointer">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>
                ✅ Active
            </option>
            <option value="expired"  {{ request('status') === 'expired'  ? 'selected' : '' }}>
                ❌ Expired
            </option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                ⏸ Inactive
            </option>
        </select>

        <button type="submit"
                class="px-4 py-2.5 rounded-xl text-sm font-semibold
                       bg-indigo-600 hover:bg-indigo-700 text-white
                       transition-all">
            Filter
        </button>

        @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('vouchers.index') }}"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 transition-all">
            Clear
        </a>
        @endif

    </form>
</div>

{{-- ── Table ────────────────────────────────────── --}}
<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Code
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Discount
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden sm:table-cell">
                        Usage
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden md:table-cell">
                        Expiry
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden lg:table-cell">
                        Customer
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                @forelse($vouchers as $voucher)
                @php
                    $badgeClass = match($voucher->status_color) {
                        'green'  => 'badge-green',
                        'red'    => 'badge-red',
                        'orange' => 'badge-orange',
                        default  => 'badge-gray',
                    };
                @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50
                            transition-colors group">

                    {{-- Code --}}
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <code class="text-sm font-black text-indigo-600
                                         dark:text-indigo-400 bg-indigo-50
                                         dark:bg-indigo-900/30 px-2.5 py-1
                                         rounded-lg tracking-wider">
                                {{ $voucher->code }}
                            </code>
                        </div>
                        @if($voucher->notes)
                        <p class="text-xs text-gray-400 dark:text-gray-500
                                   mt-0.5 truncate max-w-40">
                            {{ $voucher->notes }}
                        </p>
                        @endif
                    </td>

                    {{-- Discount --}}
                    <td class="px-4 py-4">
                        <p class="text-base font-black text-gray-900
                                   dark:text-white">
                            {{ $voucher->formatted_value }}
                            <span class="text-xs font-semibold
                                         text-gray-400 ml-1">
                                {{ $voucher->type === 'percentage'
                                    ? 'off' : 'fixed' }}
                            </span>
                        </p>
                        @if($voucher->min_order_amount > 0)
                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            Min: £{{ number_format($voucher->min_order_amount, 2) }}
                        </p>
                        @endif
                    </td>

                    {{-- Usage --}}
                    <td class="px-4 py-4 hidden sm:table-cell">
                        <p class="text-sm font-semibold text-gray-900
                                   dark:text-white">
                            {{ $voucher->used_count }}
                            @if($voucher->usage_limit)
                                / {{ $voucher->usage_limit }}
                            @else
                                / ∞
                            @endif
                        </p>
                        @if($voucher->usage_limit)
                        <div class="w-24 h-1.5 bg-gray-200 dark:bg-gray-700
                                    rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full rounded-full transition-all
                                        {{ $voucher->isUsageLimitReached()
                                            ? 'bg-red-500'
                                            : 'bg-indigo-500' }}"
                                 style="width:{{ min(100, ($voucher->used_count / $voucher->usage_limit) * 100) }}%">
                            </div>
                        </div>
                        @endif
                    </td>

                    {{-- Expiry --}}
                    <td class="px-4 py-4 hidden md:table-cell">
                        @if($voucher->expiry_date)
                        <p class="text-sm font-semibold
                                   {{ $voucher->isExpired()
                                       ? 'text-red-500 dark:text-red-400'
                                       : 'text-gray-900 dark:text-white' }}">
                            {{ $voucher->expiry_date->format('d/m/Y') }}
                        </p>
                        @if(!$voucher->isExpired())
                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            {{ $voucher->expiry_date->diffForHumans() }}
                        </p>
                        @endif
                        @else
                        <span class="text-xs text-gray-400 italic">
                            No expiry
                        </span>
                        @endif
                    </td>

                    {{-- Customer --}}
                    <td class="px-4 py-4 hidden lg:table-cell">
                        @if($voucher->assignedCustomer)
                        <p class="text-sm font-semibold text-gray-900
                                   dark:text-white">
                            {{ $voucher->assignedCustomer->name }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $voucher->assignedCustomer->phone }}
                        </p>
                        @else
                        <span class="text-xs text-gray-400 italic">
                            Anyone
                        </span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5
                                     px-2.5 py-1 rounded-full text-xs
                                     font-bold {{ $badgeClass }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                         bg-current opacity-70">
                            </span>
                            {{ $voucher->status_label }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-1.5
                                    opacity-0 group-hover:opacity-100
                                    transition-opacity">

                            {{-- Edit --}}
                            <a href="{{ route('vouchers.edit', $voucher) }}"
                               class="w-7 h-7 rounded-lg flex items-center
                                      justify-center bg-indigo-50
                                      dark:bg-indigo-900/30
                                      text-indigo-600 dark:text-indigo-400
                                      hover:bg-indigo-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0
                                             002 2h11a2 2 0 002-2v-5m-1.414
                                             -9.414a2 2 0 112.828 2.828L11.828
                                             15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            {{-- Delete --}}
                            <form method="POST"
                                  action="{{ route('vouchers.destroy', $voucher) }}"
                                  onsubmit="return confirm('Delete voucher {{ $voucher->code }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-7 h-7 rounded-lg flex
                                               items-center justify-center
                                               bg-red-50 dark:bg-red-900/30
                                               text-red-500 dark:text-red-400
                                               hover:bg-red-100 transition-colors
                                               border-none cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0
                                                 0116.138 21H7.862a2 2 0
                                                 01-1.995-1.858L5 7m5 4v6m4
                                                 -6v6m1-10V4a1 1 0 00-1-1h-4a1
                                                 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="flex flex-col items-center justify-center
                                    py-16 text-gray-400 dark:text-gray-600">
                            <svg class="w-16 h-16 mb-4 opacity-40"
                                 fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.5"
                                      d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0
                                         00-2 2v3a2 2 0 110 4v3a2 2 0 002
                                         2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2
                                         2 0 00-2-2H5z"/>
                            </svg>
                            <p class="text-sm font-semibold
                                       text-gray-500 dark:text-gray-400">
                                No vouchers found
                            </p>
                            <a href="{{ route('vouchers.create') }}"
                               class="mt-2 text-sm text-indigo-500
                                      hover:text-indigo-700 font-semibold">
                                Create your first voucher
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($vouchers->hasPages())
    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $vouchers->links() }}
    </div>
    @endif

</div>

</x-app-layout>