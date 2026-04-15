<x-app-layout>
<x-slot name="title">Products</x-slot>

<x-page-header
    title="Products"
    subtitle="Manage your product catalogue"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Products'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('products.stock') }}"
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
                      d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 010 4M5
                         8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            Stock
        </a>
        <a href="{{ route('products.create') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Product
        </a>
    </x-slot>
</x-page-header>

{{-- Flash --}}
@if(session('success'))
<div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-5
            bg-green-50 dark:bg-green-900/20
            border border-green-200 dark:border-green-800
            text-green-800 dark:text-green-300 text-sm font-semibold">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Filters --}}
<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl p-4 mb-4">
    <form method="GET" action="{{ route('products.index') }}"
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
                   placeholder="Search name or SKU..."
                   class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 transition-all">
        </div>

        {{-- Category --}}
        <select name="category_id"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700
                       rounded-xl text-sm outline-none
                       bg-gray-50 dark:bg-gray-800
                       text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all cursor-pointer">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                        {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        {{-- Brand --}}
        <select name="brand_id"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700
                       rounded-xl text-sm outline-none
                       bg-gray-50 dark:bg-gray-800
                       text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all cursor-pointer">
            <option value="">All Brands</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}"
                        {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="px-4 py-2.5 rounded-xl text-sm font-semibold
                       bg-indigo-600 hover:bg-indigo-700 text-white
                       transition-all">
            Filter
        </button>

        @if(request()->hasAny(['search','category_id','brand_id']))
        <a href="{{ route('products.index') }}"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 transition-all">
            Clear
        </a>
        @endif

    </form>
</div>

{{-- Results info --}}
<div class="flex items-center justify-between mb-3 px-1">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
        of {{ $products->total() }} products
    </p>
</div>

{{-- Table --}}
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
                        Product
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider hidden sm:table-cell">
                        Category / Brand
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider hidden md:table-cell">
                        Stock
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Price
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider hidden md:table-cell">
                        Status
                    </th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($products as $product)
                @php
                    $isOut = $product->stock <= 0;
                    $isLow = !$isOut && $product->stock <= ($product->low_stock_alert ?? 5);
                @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50
                            transition-colors group">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg
                                        bg-indigo-100 dark:bg-indigo-900/40
                                        flex items-center justify-center
                                        flex-shrink-0">
                                <svg class="w-4 h-4 text-indigo-500"
                                     fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10
                                             l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold
                                           text-gray-900 dark:text-white">
                                    {{ $product->name }}
                                </p>
                                @if($product->sku)
                                <p class="text-xs text-gray-400 font-mono">
                                    {{ $product->sku }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 hidden sm:table-cell">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $product->category?->name ?? '—' }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            {{ $product->brand?->name ?? '' }}
                        </p>
                    </td>
                    <td class="px-4 py-3.5 hidden md:table-cell">
                        <span class="text-sm font-bold
                                      {{ $isOut ? 'text-red-500' : ($isLow ? 'text-amber-500' : 'text-gray-900 dark:text-white') }}">
                            {{ $product->stock }}
                        </span>
                        @if($isOut)
                            <span class="ml-1 text-xs font-bold px-1.5 py-0.5
                                         rounded-full bg-red-100 dark:bg-red-900/30
                                         text-red-600 dark:text-red-400">
                                Out
                            </span>
                        @elseif($isLow)
                            <span class="ml-1 text-xs font-bold px-1.5 py-0.5
                                         rounded-full bg-amber-100 dark:bg-amber-900/30
                                         text-amber-600 dark:text-amber-400">
                                Low
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            £{{ number_format($product->price, 2) }}
                        </p>
                        @if($product->cost_price)
                        <p class="text-xs text-gray-400">
                            Cost: £{{ number_format($product->cost_price, 2) }}
                        </p>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 hidden md:table-cell">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full
                                      {{ $product->is_active
                                          ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                                          : 'bg-gray-100 dark:bg-gray-800 text-gray-500' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-1.5
                                    opacity-0 group-hover:opacity-100
                                    transition-opacity">
                            <a href="{{ route('products.edit', $product) }}"
                               class="w-7 h-7 rounded-lg flex items-center
                                      justify-center bg-indigo-50
                                      dark:bg-indigo-900/30 text-indigo-600
                                      hover:bg-indigo-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2
                                             0 002 2h11a2 2 0 002-2v-5m
                                             -1.414-9.414a2 2 0 112.828
                                             2.828L11.828 15H9v-2.828
                                             l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST"
                                  action="{{ route('products.destroy', $product) }}"
                                  onsubmit="return confirm('Deactivate {{ addslashes($product->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-7 h-7 rounded-lg flex items-center
                                               justify-center bg-red-50
                                               dark:bg-red-900/30 text-red-500
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
                                                 01-1.995-1.858L5 7m5 4v6
                                                 m4-6v6m1-10V4a1 1 0 00-1
                                                 -1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.5"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10
                                         l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-sm font-semibold
                                       text-gray-500 dark:text-gray-400">
                                No products found
                            </p>
                            <a href="{{ route('products.create') }}"
                               class="mt-2 text-sm text-indigo-500
                                      hover:text-indigo-700 font-semibold">
                                Add your first product
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $products->links() }}
    </div>
    @endif
</div>

</x-app-layout>