@forelse($products as $product)
@php
    $isOut = $product->stock <= 0;
    $isLow = !$isOut && $product->stock <= ($product->low_stock_alert ?? 5);
@endphp
<tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">

    {{-- Product --}}
    <td class="px-4 py-3.5">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40
                        flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-indigo-500" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4
                             7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                    {{ $product->name }}
                </p>
                @if($product->sku)
                <p class="text-xs text-gray-400 font-mono">{{ $product->sku }}</p>
                @endif
            </div>
        </div>
    </td>

    {{-- Category / Brand --}}
    <td class="px-4 py-3.5 hidden sm:table-cell">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ $product->category?->name ?? '—' }}
        </p>
        <p class="text-xs text-gray-400 dark:text-gray-500">
            {{ $product->brand?->name ?? '' }}
        </p>
    </td>

    {{-- Stock --}}
    <td class="px-4 py-3.5 hidden md:table-cell">
        <span data-product-stock="{{ $product->id }}"
              class="text-sm font-bold
                     {{ $isOut ? 'text-red-500' : ($isLow ? 'text-amber-500' : 'text-gray-900 dark:text-white') }}">
            {{ $product->stock }}
        </span>
        @if($isOut)
            <span class="ml-1 text-xs font-bold px-1.5 py-0.5 rounded-full
                         bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                Out
            </span>
        @elseif($isLow)
            <span class="ml-1 text-xs font-bold px-1.5 py-0.5 rounded-full
                         bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                Low
            </span>
        @endif
    </td>

    {{-- Price --}}
    <td class="px-4 py-3.5">
        <p class="text-sm font-bold text-gray-900 dark:text-white">
            £{{ number_format($product->sell_price, 2) }}
        </p>
        @if($product->cost_price)
        <p class="text-xs text-gray-400">
            Cost: £{{ number_format($product->cost_price, 2) }}
        </p>
        @endif
    </td>

    {{-- Status --}}
    <td class="px-4 py-3.5 hidden md:table-cell">
        <span class="text-xs font-bold px-2.5 py-1 rounded-full
                     {{ $product->is_active
                         ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                         : 'bg-gray-100 dark:bg-gray-800 text-gray-500' }}">
            {{ $product->is_active ? 'Active' : 'Inactive' }}
        </span>
    </td>

    {{-- Actions --}}
    <td class="px-4 py-3.5">
        <div class="flex items-center gap-1.5
                    opacity-0 group-hover:opacity-100 transition-opacity">

            {{-- Top Up --}}
            <button onclick="ProductIndex.openTopup(
                        {{ $product->id }},
                        '{{ addslashes($product->name) }}',
                        {{ $product->stock }}
                    )"
                    title="Top up stock"
                    class="w-7 h-7 rounded-lg flex items-center justify-center
                           bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600
                           hover:bg-emerald-100 transition-colors border-none
                           cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>

            {{-- Movements --}}
            <a href="{{ route('products.movements', $product) }}"
               title="View stock movements"
               class="w-7 h-7 rounded-lg flex items-center justify-center
                      bg-amber-50 dark:bg-amber-900/30 text-amber-600
                      hover:bg-amber-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0
                             002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0
                             012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2
                             2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2
                             0 01-2-2z"/>
                </svg>
            </a>

            {{-- Edit --}}
            <a href="{{ route('products.edit', $product) }}"
               title="Edit"
               class="w-7 h-7 rounded-lg flex items-center justify-center
                      bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600
                      hover:bg-indigo-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0
                             002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828
                             15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>

            {{-- Delete --}}
            <form method="POST"
                  action="{{ route('products.destroy', $product) }}"
                  onsubmit="return confirm('Deactivate {{ addslashes($product->name) }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" title="Deactivate"
                        class="w-7 h-7 rounded-lg flex items-center justify-center
                               bg-red-50 dark:bg-red-900/30 text-red-500
                               hover:bg-red-100 transition-colors
                               border-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2
                                 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1
                                 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>

        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6">
        <div class="flex flex-col items-center justify-center
                    py-16 text-gray-400 dark:text-gray-600">
            <svg class="w-16 h-16 mb-4 opacity-40" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4
                         7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                No products found
            </p>
            <a href="{{ route('products.create') }}"
               class="mt-2 text-sm text-indigo-500 hover:text-indigo-700 font-semibold">
                Add your first product
            </a>
        </div>
    </td>
</tr>
@endforelse