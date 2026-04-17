<x-app-layout>
<x-slot name="title">Sales History</x-slot>

@push('styles')
<style>
    /* ── Expandable rows ─────────────────────────── */
    .sale-expand {
        display: none;
    }
    .sale-expand.open {
        display: table-row;
        animation: fadeIn 0.2s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    /* ── Row hover ───────────────────────────────── */
    .sale-row {
        cursor: pointer;
        transition: background 0.1s;
    }

    /* ── Status badges ───────────────────────────── */
    .badge-paid    { background:#dcfce7;color:#166534; }
    .badge-pending { background:#fef9c3;color:#713f12; }
    .badge-partial { background:#dbeafe;color:#1e40af; }
    .badge-refunded{ background:#fee2e2;color:#991b1b; }

    /* ── Method badges ───────────────────────────── */
    .method-cash  { background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
    .method-card  { background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe; }
    .method-split { background:#faf5ff;color:#6b21a8;border:1px solid #e9d5ff; }
    .method-trade { background:#fff7ed;color:#9a3412;border:1px solid #fed7aa; }
    .method-other { background:#f8fafc;color:#475569;border:1px solid #e2e8f0; }

    /* ── Filter tag ──────────────────────────────── */
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
        white-space: nowrap;
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
    title="Sales History"
    subtitle="View and manage all completed sales"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Sales'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('products.index') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800
                  transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4
                         7m8 4v10M4 7v10l8 4"/>
            </svg>
            Products
        </a>
        <a href="{{ route('pos.index') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7
                         13l-2.293 2.293c-.63.63-.184 1.707.707
                         1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8
                         2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Open POS
        </a>
    </x-slot>
</x-page-header>

{{-- ── Filters ──────────────────────────────────── --}}
<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl p-4 mb-4">

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
                   placeholder="Reference, customer name or phone..."
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

        {{-- Payment Status --}}
        <div>
            <select id="filter-payment-status"
                    class="px-3 py-2.5
                           border border-gray-200 dark:border-gray-700
                           rounded-xl text-sm outline-none
                           bg-gray-50 dark:bg-gray-800
                           text-gray-700 dark:text-gray-300
                           focus:border-indigo-500 transition-all
                           cursor-pointer">
                <option value="">All Statuses</option>
                <option value="paid"     {{ request('payment_status') === 'paid'     ? 'selected' : '' }}>
                    ✅ Paid
                </option>
                <option value="partial"  {{ request('payment_status') === 'partial'  ? 'selected' : '' }}>
                    🔵 Partial
                </option>
                <option value="pending"  {{ request('payment_status') === 'pending'  ? 'selected' : '' }}>
                    🟡 Pending
                </option>
                <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>
                    🔴 Refunded
                </option>
            </select>
        </div>

        {{-- Payment Method --}}
        <div>
            <select id="filter-payment-method"
                    class="px-3 py-2.5
                           border border-gray-200 dark:border-gray-700
                           rounded-xl text-sm outline-none
                           bg-gray-50 dark:bg-gray-800
                           text-gray-700 dark:text-gray-300
                           focus:border-indigo-500 transition-all
                           cursor-pointer">
                <option value="">All Methods</option>
                <option value="cash"  {{ request('payment_method') === 'cash'  ? 'selected' : '' }}>
                    💵 Cash
                </option>
                <option value="card"  {{ request('payment_method') === 'card'  ? 'selected' : '' }}>
                    💳 Card
                </option>
                <option value="split" {{ request('payment_method') === 'split' ? 'selected' : '' }}>
                    ✂️ Split
                </option>
                <option value="trade" {{ request('payment_method') === 'trade' ? 'selected' : '' }}>
                    🔄 Trade
                </option>
            </select>
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

{{-- ── Active Filter Tags ───────────────────────── --}}
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

{{-- ── Results Info ─────────────────────────────── --}}
<div class="flex items-center justify-between mb-3 px-1">
    <p id="results-info"
       class="text-sm text-gray-500 dark:text-gray-400">
        Showing {{ $sales->firstItem() ?? 0 }}–{{ $sales->lastItem() ?? 0 }}
        of {{ $sales->total() }} sales
    </p>
    <div id="loading-indicator"
         style="display:none;"
         class="flex items-center gap-2 text-sm
                text-indigo-500 font-semibold">
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
        <table class="w-full">
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
                                uppercase tracking-wider
                                hidden sm:table-cell">
                        Items
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden md:table-cell">
                        Method
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden md:table-cell">
                        Status
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden lg:table-cell">
                        Total
                    </th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody id="sales-tbody"
       class="divide-y divide-gray-100 dark:divide-gray-800">
    @forelse($sales as $sale)
        @include('sales.partials.index-row', compact('sale'))
    @empty
        @include('sales.partials.index-empty')
    @endforelse
</tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div id="pagination-wrapper"
         class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $sales->links() }}
    </div>

</div>

@push('scripts')
<script src="{{ asset('js/sales-index.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    SalesIndex.init({
        fetchUrl : '{{ route("sales.index") }}',
        csrf     : '{{ csrf_token() }}',
    });
});
</script>
@endpush

</x-app-layout>