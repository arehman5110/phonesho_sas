@php
    $isOut = $product->stock <= 0;
    $isLow = !$isOut && $product->stock <= ($product->low_stock_alert ?? 5);
    $isOk  = !$isOut && !$isLow;

    $stockClass = match(true) {
        $isOut => 'stock-out',
        $isLow => 'stock-low',
        default => 'stock-ok',
    };

    $rowBg = match(true) {
        $isOut => 'hover:bg-red-50/40 dark:hover:bg-red-900/10',
        $isLow => 'hover:bg-amber-50/40 dark:hover:bg-amber-900/10',
        default => 'hover:bg-indigo-50/40 dark:hover:bg-indigo-900/10',
    };
@endphp

{{-- ── Main Row ─────────────────────────────────── --}}
<tr class="stock-row group {{ $rowBg }} transition-colors"
    onclick="StockManager.toggleRow({{ $product->id }}, this)">

    {{-- Chevron --}}
    <td class="px-4 py-3.5 w-8">
        <div id="stock-chevron-{{ $product->id }}"
             class="w-6 h-6 rounded-full flex items-center justify-center
                    bg-gray-100 dark:bg-gray-800 text-gray-400
                    transition-all group-hover:text-indigo-500
                    group-hover:bg-indigo-100
                    dark:group-hover:bg-indigo-900/40">
            <svg class="w-3.5 h-3.5 transition-transform duration-200"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </td>

    {{-- Product Name --}}
    <td class="px-4 py-3.5">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center
                        justify-center flex-shrink-0
                        {{ $isOut
                            ? 'bg-red-100 dark:bg-red-900/30'
                            : ($isLow
                                ? 'bg-amber-100 dark:bg-amber-900/30'
                                : 'bg-indigo-100 dark:bg-indigo-900/30') }}">
                <svg class="w-4 h-4
                            {{ $isOut
                                ? 'text-red-500'
                                : ($isLow
                                    ? 'text-amber-500'
                                    : 'text-indigo-500') }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10
                             L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ $product->name }}
                </p>
                @if($product->sku)
                <p class="text-xs text-gray-400 dark:text-gray-500
                           font-mono">
                    {{ $product->sku }}
                </p>
                @endif
            </div>
        </div>
    </td>

    {{-- Category --}}
    <td class="px-4 py-3.5 hidden sm:table-cell">
        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                     bg-gray-100 dark:bg-gray-800
                     text-gray-600 dark:text-gray-400">
            {{ $product->category?->name ?? '—' }}
        </span>
    </td>

    {{-- Brand --}}
    <td class="px-4 py-3.5 hidden md:table-cell">
        <span class="text-sm text-gray-600 dark:text-gray-400">
            {{ $product->brand?->name ?? '—' }}
        </span>
    </td>

    {{-- Stock --}}
    <td class="px-4 py-3.5">
        <div class="flex items-center gap-2">
            <span id="stock-qty-{{ $product->id }}"
                  class="text-lg {{ $stockClass }}">
                {{ $product->stock }}
            </span>

            @if($isOut)
            <span class="text-xs font-bold px-2 py-0.5 rounded-full
                         bg-red-100 dark:bg-red-900/30
                         text-red-600 dark:text-red-400">
                Out
            </span>
            @elseif($isLow)
            <span class="text-xs font-bold px-2 py-0.5 rounded-full
                         bg-amber-100 dark:bg-amber-900/30
                         text-amber-600 dark:text-amber-400">
                Low
            </span>
            @endif
        </div>

        @if($product->low_stock_alert)
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
            Alert at {{ $product->low_stock_alert }}
        </p>
        @endif
    </td>

    {{-- Price --}}
    <td class="px-4 py-3.5 hidden lg:table-cell">
        <p class="text-sm font-bold text-gray-900 dark:text-white">
            £{{ number_format($product->price, 2) }}
        </p>
        @if($product->cost_price)
        <p class="text-xs text-gray-400 dark:text-gray-500">
            Cost: £{{ number_format($product->cost_price, 2) }}
        </p>
        @endif
    </td>

    {{-- Actions --}}
    <td class="px-4 py-3.5" onclick="event.stopPropagation()">
        <button type="button"
                onclick="StockManager.openModal(
                    {{ $product->id }},
                    '{{ addslashes($product->name) }}',
                    {{ $product->stock }}
                )"
                class="flex items-center gap-1.5 px-3 py-1.5
                       rounded-lg text-xs font-bold
                       bg-indigo-600 hover:bg-indigo-700
                       active:scale-95 text-white transition-all
                       border-none cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Top Up
        </button>
    </td>

</tr>

{{-- ── Expand Row — Movement History ──────────────── --}}
<tr id="stock-expand-{{ $product->id }}" class="stock-expand">
    <td colspan="7"
        class="px-0 py-0"
        style="background:linear-gradient(to bottom,
               #f0f4ff 0%,#f8faff 100%);">

        <div id="stock-movements-{{ $product->id }}"
             style="border-top:3px solid #6366f1;
                    border-bottom:3px solid #e0e7ff;
                    padding:16px 24px;">

            {{-- Loading state --}}
            <div id="movements-loading-{{ $product->id }}"
                 class="flex items-center gap-2 py-4
                        text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 animate-spin" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                Loading movement history...
            </div>

            {{-- Movements content (filled by JS) --}}
            <div id="movements-content-{{ $product->id }}"
                 style="display:none;">
            </div>

        </div>
    </td>
</tr>