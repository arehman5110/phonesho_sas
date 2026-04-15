@php $isEdit = !is_null($product); @endphp

{{-- ── Validation Errors ───────────────────────── --}}
@if($errors->any())
<div class="flex items-start gap-3 px-4 py-3 rounded-xl mb-5
            bg-red-50 dark:bg-red-900/20
            border border-red-200 dark:border-red-800">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <ul class="text-sm text-red-700 dark:text-red-400 space-y-0.5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="product-form"
      method="POST"
      action="{{ $isEdit ? route('products.update', $product) : route('products.store') }}">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    {{-- Hidden method override for JS switching --}}
    <input type="hidden" id="form-method-input" name="_method_override">

    {{-- Hidden product ID for edit mode --}}
    <input type="hidden"
           id="product-id-input"
           name="product_id"
           value="{{ $isEdit ? $product->id : '' }}">

    <div class="grid grid-cols-12 gap-5">

        {{-- ══════════════════════════════════════ --}}
        {{-- LEFT — Main Details                   --}}
        {{-- ══════════════════════════════════════ --}}
        <div class="col-span-12 lg:col-span-8 space-y-5">

            {{-- Product Info Card --}}
            <div class="bg-white dark:bg-gray-900
                        border border-gray-200 dark:border-gray-700
                        rounded-2xl overflow-hidden">

                {{-- Card Header --}}
                <div class="px-5 py-4 border-b border-gray-100
                            dark:border-gray-800
                            bg-gray-50 dark:bg-gray-800/50
                            flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100
                                    dark:bg-indigo-900/40 flex items-center
                                    justify-center">
                            <svg class="w-4 h-4 text-indigo-600
                                         dark:text-indigo-400"
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
                            <h3 id="product-form-title"
                                class="text-sm font-bold text-gray-900
                                        dark:text-white">
                                {{ $isEdit ? 'Edit Product' : 'New Product' }}
                            </h3>
                            <span id="product-form-badge"
                                  class="inline-flex items-center gap-1.5
                                         px-2 py-0.5 rounded-full text-xs
                                         font-bold mt-0.5
                                         {{ $isEdit
                                             ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400'
                                             : 'bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400' }}"
                                  style="{{ !$isEdit ? '' : '' }}">
                                {{ $isEdit ? 'Editing existing' : 'Creating new' }}
                            </span>
                        </div>
                    </div>
                    @if(!$isEdit)
                    <button type="button"
                            onclick="resetToCreate()"
                            class="text-xs text-gray-400 hover:text-indigo-500
                                   font-semibold transition-colors
                                   bg-transparent border-none cursor-pointer">
                        Reset
                    </button>
                    @endif
                </div>

                <div class="p-5 space-y-4">

                    {{-- Product Name with Autocomplete --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Product Name
                            <span class="text-red-500 ml-0.5">*</span>
                        </label>

                        {{-- Search wrapper --}}
                        <div class="relative">
                            <div class="absolute left-3 top-1/2
                                        -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400"
                                     fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14
                                             0 7 7 0 0114 0"/>
                                </svg>
                            </div>

                            <input type="text"
                                   id="product-name-input"
                                   name="name"
                                   value="{{ old('name', $product?->name) }}"
                                   placeholder="Type to search or create..."
                                   autocomplete="off"
                                   required
                                   class="w-full pl-9 pr-4 py-2.5
                                          border border-gray-200 dark:border-gray-700
                                          rounded-xl text-sm outline-none
                                          bg-gray-50 dark:bg-gray-800
                                          text-gray-900 dark:text-white
                                          placeholder-gray-400
                                          focus:border-indigo-500
                                          focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900
                                          transition-all">

                            {{-- Dropdown --}}
                            <div id="product-name-dropdown"
                                 class="hidden absolute top-full left-0
                                        right-0 mt-1.5 z-50
                                        bg-white dark:bg-gray-800
                                        border border-gray-200 dark:border-gray-700
                                        rounded-xl shadow-xl
                                        max-h-72 overflow-y-auto">
                            </div>

                        </div>

                        <p class="mt-1.5 text-xs text-gray-400
                                   dark:text-gray-500">
                            Search existing products to edit, or type a new
                            name to create
                        </p>
                    </div>

                    {{-- SKU --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            SKU / Barcode
                        </label>
                        <input type="text"
                               id="field-sku"
                               name="sku"
                               value="{{ old('sku', $product?->sku) }}"
                               placeholder="e.g. IPHONE-13-BLK..."
                               class="w-full px-3.5 py-2.5
                                      border border-gray-200 dark:border-gray-700
                                      rounded-xl text-sm outline-none
                                      bg-gray-50 dark:bg-gray-800
                                      text-gray-900 dark:text-white
                                      placeholder-gray-400
                                      focus:border-indigo-500
                                      focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900
                                      transition-all font-mono">
                    </div>

                    {{-- Category + Brand --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-xs font-bold
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider mb-1.5">
                                Category
                            </label>
                            <select id="field-category"
                                    name="category_id"
                                    class="w-full px-3.5 py-2.5
                                           border border-gray-200 dark:border-gray-700
                                           rounded-xl text-sm outline-none
                                           bg-gray-50 dark:bg-gray-800
                                           text-gray-900 dark:text-white
                                           focus:border-indigo-500
                                           transition-all cursor-pointer">
                                <option value="">No Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                            {{ old('category_id', $product?->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider mb-1.5">
                                Brand
                            </label>
                            <select id="field-brand"
                                    name="brand_id"
                                    class="w-full px-3.5 py-2.5
                                           border border-gray-200 dark:border-gray-700
                                           rounded-xl text-sm outline-none
                                           bg-gray-50 dark:bg-gray-800
                                           text-gray-900 dark:text-white
                                           focus:border-indigo-500
                                           transition-all cursor-pointer">
                                <option value="">No Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $product?->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Description
                        </label>
                        <textarea id="field-description"
                                  name="description"
                                  rows="3"
                                  placeholder="Optional product description..."
                                  class="w-full px-3.5 py-2.5 resize-none
                                         border border-gray-200 dark:border-gray-700
                                         rounded-xl text-sm outline-none
                                         bg-gray-50 dark:bg-gray-800
                                         text-gray-900 dark:text-white
                                         placeholder-gray-400
                                         focus:border-indigo-500
                                         transition-all">{{ old('description', $product?->description) }}</textarea>
                    </div>

                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════ --}}
        {{-- RIGHT — Pricing & Stock               --}}
        {{-- ══════════════════════════════════════ --}}
        <div class="col-span-12 lg:col-span-4 space-y-5">

            {{-- Pricing Card --}}
            <div class="bg-white dark:bg-gray-900
                        border border-gray-200 dark:border-gray-700
                        rounded-2xl overflow-hidden">

                <div class="px-5 py-4 border-b border-gray-100
                            dark:border-gray-800
                            bg-gray-50 dark:bg-gray-800/50
                            flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-100
                                dark:bg-green-900/40 flex items-center
                                justify-center">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400"
                             fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2
                                     3 .895 3 2-1.343 2-3 2m0-8c1.11 0
                                     2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0
                                     -1c-1.11 0-2.08-.402-2.599-1M21 12a9
                                     9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                        Pricing
                    </h3>
                </div>

                <div class="p-5 space-y-4">

                    {{-- Selling Price --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Selling Price
                            <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2
                                         -translate-y-1/2 text-gray-400
                                         font-semibold pointer-events-none">
                                £
                            </span>
                            <input type="number"
                                   id="field-price"
                                   name="price"
                                   value="{{ old('price', $product?->price) }}"
                                   min="0"
                                   step="0.01"
                                   placeholder="0.00"
                                   required
                                   class="w-full pl-7 pr-4 py-2.5
                                          border border-gray-200 dark:border-gray-700
                                          rounded-xl text-sm outline-none
                                          bg-gray-50 dark:bg-gray-800
                                          text-gray-900 dark:text-white
                                          focus:border-indigo-500
                                          focus:ring-2 focus:ring-indigo-500/10
                                          transition-all">
                        </div>
                    </div>

                    {{-- Cost Price --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Cost Price
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2
                                         -translate-y-1/2 text-gray-400
                                         font-semibold pointer-events-none">
                                £
                            </span>
                            <input type="number"
                                   id="field-cost-price"
                                   name="cost_price"
                                   value="{{ old('cost_price', $product?->cost_price) }}"
                                   min="0"
                                   step="0.01"
                                   placeholder="0.00"
                                   class="w-full pl-7 pr-4 py-2.5
                                          border border-gray-200 dark:border-gray-700
                                          rounded-xl text-sm outline-none
                                          bg-gray-50 dark:bg-gray-800
                                          text-gray-900 dark:text-white
                                          focus:border-indigo-500
                                          transition-all">
                        </div>
                        <p class="mt-1 text-xs text-gray-400">
                            For internal margin tracking
                        </p>
                    </div>

                </div>
            </div>

            {{-- Stock Card --}}
            <div class="bg-white dark:bg-gray-900
                        border border-gray-200 dark:border-gray-700
                        rounded-2xl overflow-hidden">

                <div class="px-5 py-4 border-b border-gray-100
                            dark:border-gray-800
                            bg-gray-50 dark:bg-gray-800/50
                            flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100
                                dark:bg-blue-900/40 flex items-center
                                justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400"
                             fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0
                                     010 4M5 8v10a2 2 0 002 2h10a2 2 0
                                     002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                        Stock
                    </h3>
                </div>

                <div class="p-5 space-y-4">

                    {{-- Stock --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Current Stock
                            <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="number"
                               id="field-stock"
                               name="stock"
                               value="{{ old('stock', $product?->stock ?? 0) }}"
                               min="0"
                               required
                               class="w-full px-3.5 py-2.5
                                      border border-gray-200 dark:border-gray-700
                                      rounded-xl text-sm outline-none
                                      bg-gray-50 dark:bg-gray-800
                                      text-gray-900 dark:text-white
                                      focus:border-indigo-500
                                      focus:ring-2 focus:ring-indigo-500/10
                                      transition-all">
                    </div>

                    {{-- Low Stock Alert --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Low Stock Alert
                        </label>
                        <input type="number"
                               id="field-low-stock-alert"
                               name="low_stock_alert"
                               value="{{ old('low_stock_alert', $product?->low_stock_alert ?? 5) }}"
                               min="0"
                               class="w-full px-3.5 py-2.5
                                      border border-gray-200 dark:border-gray-700
                                      rounded-xl text-sm outline-none
                                      bg-gray-50 dark:bg-gray-800
                                      text-gray-900 dark:text-white
                                      focus:border-indigo-500
                                      transition-all">
                        <p class="mt-1 text-xs text-gray-400">
                            Alert when stock drops below this
                        </p>
                    </div>

                </div>
            </div>

            {{-- Settings Card --}}
            <div class="bg-white dark:bg-gray-900
                        border border-gray-200 dark:border-gray-700
                        rounded-2xl overflow-hidden">

                <div class="px-5 py-4 border-b border-gray-100
                            dark:border-gray-800
                            bg-gray-50 dark:bg-gray-800/50
                            flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-100
                                dark:bg-purple-900/40 flex items-center
                                justify-center">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400"
                             fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756
                                     3.35 0a1.724 1.724 0 002.573 1.066c1.543
                                     -.94 3.31.826 2.37 2.37a1.724 1.724 0
                                     001.065 2.572c1.756.426 1.756 2.924 0
                                     3.35a1.724 1.724 0 00-1.066 2.573c.94
                                     1.543-.826 3.31-2.37 2.37a1.724 1.724 0
                                     00-2.572 1.065c-.426 1.756-2.924 1.756
                                     -3.35 0a1.724 1.724 0 00-2.573-1.066c
                                     -1.543.94-3.31-.826-2.37-2.37a1.724
                                     1.724 0 00-1.065-2.572c-1.756-.426
                                     -1.756-2.924 0-3.35a1.724 1.724 0
                                     001.066-2.573c-.94-1.543.826-3.31
                                     2.37-2.37.996.608 2.296.07 2.572-1.065z
                                     M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                        Settings
                    </h3>
                </div>

                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold
                                       text-gray-900 dark:text-white">
                                Active
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Show in POS and listings
                            </p>
                        </div>
                        <label class="relative inline-flex items-center
                                      cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox"
                                   id="field-is-active"
                                   name="is_active"
                                   value="1"
                                   class="sr-only peer"
                                   {{ old('is_active', $product?->is_active ?? true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700
                                        rounded-full peer transition-all
                                        peer-checked:bg-indigo-500
                                        after:content-[''] after:absolute
                                        after:top-[2px] after:left-[2px]
                                        after:bg-white after:rounded-full
                                        after:h-5 after:w-5
                                        after:transition-all
                                        peer-checked:after:translate-x-5">
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <a href="{{ route('products.index') }}"
                   class="flex-1 py-3 rounded-xl text-sm font-semibold
                          text-center border border-gray-200 dark:border-gray-700
                          text-gray-600 dark:text-gray-400
                          hover:bg-gray-50 dark:hover:bg-gray-800
                          transition-all">
                    Cancel
                </a>
                <button type="submit"
                        id="product-submit-btn"
                        class="flex-1 py-3 rounded-xl text-sm font-bold
                               bg-indigo-600 hover:bg-indigo-700
                               active:scale-95 text-white transition-all
                               flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ $isEdit ? 'Update Product' : 'Create Product' }}
                </button>
            </div>

        </div>

    </div>
</form>