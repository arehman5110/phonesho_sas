<x-app-layout>
<x-slot name="title">Categories & Brands</x-slot>

@push('styles')
<style>
    [x-cloak] { display: none !important; }

    .tab-btn {
        padding: 7px 18px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        background: transparent;
        color: #64748b;
        transition: all 0.15s;
        white-space: nowrap;
    }
    .tab-btn.active {
        background: #6366f1;
        color: #fff;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
    }
    .dark .tab-btn { color: #94a3b8; }
    .dark .tab-btn.active { color: #fff; background: #6366f1; }

    .cb-row { cursor: pointer; }
    .cb-row.selected { background: #eef2ff !important; }
    .dark .cb-row.selected { background: #1e1b4b !important; }

    .type-acc  { background:#dbeafe;color:#1e40af; }
    .type-rep  { background:#fef3c7;color:#92400e; }
    .type-both { background:#dcfce7;color:#166534; }
</style>
@endpush

<x-page-header
    title="Categories & Brands"
    subtitle="Manage product categories and brands"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Categories & Brands'],
    ]">
</x-page-header>

<div x-data="CatBrand()" class="flex flex-col lg:flex-row gap-5 items-start">

    {{-- ══════════════════════════════════════════ --}}
    {{-- LEFT — Table                              --}}
    {{-- ══════════════════════════════════════════ --}}
    <div class="w-full lg:flex-1 min-w-0">

        {{-- Top bar --}}
        <div class="bg-white dark:bg-gray-900
                    border border-gray-200 dark:border-gray-700
                    rounded-2xl p-4 mb-4">
            <div class="flex flex-wrap items-center gap-3">

                {{-- Tabs --}}
                <div class="flex gap-1 bg-gray-100 dark:bg-gray-800
                            rounded-xl p-1 flex-shrink-0">
                    <button type="button"
                            class="tab-btn"
                            :class="tab === 'categories' ? 'active' : ''"
                            @click="switchTab('categories')">
                        📁 Categories
                        (<span x-text="categoriesTotal"></span>)
                    </button>
                    <button type="button"
                            class="tab-btn"
                            :class="tab === 'brands' ? 'active' : ''"
                            @click="switchTab('brands')">
                        🏷 Brands
                        (<span x-text="brandsTotal"></span>)
                    </button>
                </div>

                {{-- Search --}}
                <div class="flex-1 min-w-36 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2
                                w-4 h-4 text-gray-400 pointer-events-none"
                         fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input type="text"
                           x-model="search"
                           @input.debounce.300ms="fetchList()"
                           :placeholder="'Search ' + tab + '...'"
                           class="w-full pl-9 pr-4 py-2.5
                                  border border-gray-200 dark:border-gray-700
                                  rounded-xl text-sm outline-none
                                  bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  placeholder-gray-400
                                  focus:border-indigo-500
                                  focus:bg-white dark:focus:bg-gray-900
                                  transition-all">
                </div>

                {{-- New button --}}
                <button type="button"
                        @click="openCreate()"
                        class="flex items-center gap-2 px-4 py-2.5
                               rounded-xl text-sm font-bold flex-shrink-0
                               bg-indigo-600 hover:bg-indigo-700
                               active:scale-95 text-white transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span x-text="tab === 'categories'
                        ? 'New Category' : 'New Brand'">
                    </span>
                </button>

            </div>
        </div>

        {{-- Table card --}}
        <div class="bg-white dark:bg-gray-900
                    border border-gray-200 dark:border-gray-700
                    rounded-2xl">

            {{-- Loading --}}
            <div x-show="isLoading"
                 x-cloak
                 class="flex items-center justify-center py-16 gap-3
                        text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-5 h-5 animate-spin text-indigo-500"
                     fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                Loading...
            </div>

            {{-- Categories table --}}
            <div x-show="!isLoading && tab === 'categories'"
                 x-cloak>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200
                                        dark:border-gray-700
                                        bg-gray-50 dark:bg-gray-800/50">
                                <th class="text-left px-4 py-3 text-xs
                                            font-bold uppercase tracking-wider
                                            text-gray-500 dark:text-gray-400">
                                    Name
                                </th>
                                <th class="text-left px-4 py-3 text-xs
                                            font-bold uppercase tracking-wider
                                            text-gray-500 dark:text-gray-400
                                            hidden sm:table-cell">
                                    Type
                                </th>
                                <th class="text-left px-4 py-3 text-xs
                                            font-bold uppercase tracking-wider
                                            text-gray-500 dark:text-gray-400
                                            hidden md:table-cell">
                                    Products
                                </th>
                                <th class="text-left px-4 py-3 text-xs
                                            font-bold uppercase tracking-wider
                                            text-gray-500 dark:text-gray-400">
                                    Status
                                </th>
                                <th class="w-24 px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100
                                      dark:divide-gray-800">

                            <template x-if="categories.length === 0">
                                <tr>
                                    <td colspan="5">
                                        <div class="flex flex-col
                                                    items-center py-14
                                                    text-gray-400
                                                    dark:text-gray-600">
                                            <svg class="w-14 h-14 mb-3
                                                         opacity-40"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="1.5"
                                                      d="M3 7v10a2 2 0 002
                                                         2h14a2 2 0 002-2V9a2
                                                         2 0 00-2-2h-6l-2-2H5
                                                         a2 2 0 00-2 2z"/>
                                            </svg>
                                            <p class="text-sm font-semibold">
                                                No categories found
                                            </p>
                                            <button type="button"
                                                    @click="openCreate()"
                                                    class="mt-2 text-sm
                                                           font-bold
                                                           text-indigo-500
                                                           hover:text-indigo-700
                                                           bg-transparent
                                                           border-none
                                                           cursor-pointer">
                                                + Create first category
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <template x-for="cat in categories"
                                      :key="cat.id">
                                <tr class="cb-row group
                                            hover:bg-indigo-50/40
                                            dark:hover:bg-indigo-900/10
                                            transition-colors"
                                    :class="selectedId === cat.id
                                        ? 'selected' : ''"
                                    @click="editItem(cat)">

                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center
                                                    gap-2.5">
                                            <div class="w-8 h-8 rounded-lg
                                                        bg-indigo-100
                                                        dark:bg-indigo-900/40
                                                        flex items-center
                                                        justify-center
                                                        text-base
                                                        flex-shrink-0">
                                                📁
                                            </div>
                                            <span class="text-sm font-semibold
                                                         text-gray-900
                                                         dark:text-white"
                                                  x-text="cat.name">
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3.5
                                               hidden sm:table-cell">
                                        <span class="text-xs font-bold
                                                     px-2.5 py-1 rounded-full"
                                              :class="cat.type === 'accessories'
                                                  ? 'type-acc'
                                                  : cat.type === 'repair'
                                                      ? 'type-rep'
                                                      : 'type-both'"
                                              x-text="cat.type_label">
                                        </span>
                                    </td>

                                    <td class="px-4 py-3.5
                                               hidden md:table-cell">
                                        <span class="text-sm text-gray-500
                                                     dark:text-gray-400"
                                              x-text="cat.products_count
                                                  + ' products'">
                                        </span>
                                    </td>

                                    <td class="px-4 py-3.5">
                                        <span class="text-xs font-bold
                                                     px-2.5 py-1 rounded-full"
                                              :class="cat.is_active
                                                  ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                                                  : 'bg-gray-100 dark:bg-gray-800 text-gray-500'"
                                              x-text="cat.is_active
                                                  ? 'Active' : 'Inactive'">
                                        </span>
                                    </td>

                                    <td class="px-4 py-3.5"
                                        @click.stop>
                                        <div class="flex items-center
                                                    gap-1.5 opacity-0
                                                    group-hover:opacity-100
                                                    transition-opacity">
                                            <button type="button"
                                                    @click="editItem(cat)"
                                                    title="Edit"
                                                    class="w-7 h-7 rounded-lg
                                                           flex items-center
                                                           justify-center
                                                           bg-indigo-50
                                                           dark:bg-indigo-900/30
                                                           text-indigo-600
                                                           hover:bg-indigo-100
                                                           transition-colors
                                                           border-none
                                                           cursor-pointer">
                                                <svg class="w-3.5 h-3.5"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M11 5H6a2 2 0
                                                             00-2 2v11a2 2 0
                                                             002 2h11a2 2 0
                                                             002-2v-5m-1.414
                                                             -9.414a2 2 0
                                                             112.828 2.828
                                                             L11.828 15H9v
                                                             -2.828l8.586
                                                             -8.586z"/>
                                                </svg>
                                            </button>
                                            <button type="button"
                                                    @click="deleteItem(cat.id, cat.name)"
                                                    title="Delete"
                                                    class="w-7 h-7 rounded-lg
                                                           flex items-center
                                                           justify-center
                                                           bg-red-50
                                                           dark:bg-red-900/30
                                                           text-red-500
                                                           hover:bg-red-100
                                                           transition-colors
                                                           border-none
                                                           cursor-pointer">
                                                <svg class="w-3.5 h-3.5"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867
                                                             12.142A2 2 0
                                                             0116.138 21H7.862
                                                             a2 2 0 01-1.995
                                                             -1.858L5 7m5 4v6
                                                             m4-6v6m1-10V4a1
                                                             1 0 00-1-1h-4a1
                                                             1 0 00-1 1v3
                                                             M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            </template>

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Brands table --}}
            <div x-show="!isLoading && tab === 'brands'"
                 x-cloak>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200
                                        dark:border-gray-700
                                        bg-gray-50 dark:bg-gray-800/50">
                                <th class="text-left px-4 py-3 text-xs
                                            font-bold uppercase tracking-wider
                                            text-gray-500 dark:text-gray-400">
                                    Name
                                </th>
                                <th class="text-left px-4 py-3 text-xs
                                            font-bold uppercase tracking-wider
                                            text-gray-500 dark:text-gray-400
                                            hidden md:table-cell">
                                    Products
                                </th>
                                <th class="text-left px-4 py-3 text-xs
                                            font-bold uppercase tracking-wider
                                            text-gray-500 dark:text-gray-400">
                                    Status
                                </th>
                                <th class="w-24 px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100
                                      dark:divide-gray-800">

                            <template x-if="brands.length === 0">
                                <tr>
                                    <td colspan="4">
                                        <div class="flex flex-col
                                                    items-center py-14
                                                    text-gray-400
                                                    dark:text-gray-600">
                                            <svg class="w-14 h-14 mb-3
                                                         opacity-40"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="1.5"
                                                      d="M7 7h.01M17 17h.01
                                                         M5 19L19 5"/>
                                            </svg>
                                            <p class="text-sm font-semibold">
                                                No brands found
                                            </p>
                                            <button type="button"
                                                    @click="openCreate()"
                                                    class="mt-2 text-sm
                                                           font-bold
                                                           text-indigo-500
                                                           hover:text-indigo-700
                                                           bg-transparent
                                                           border-none
                                                           cursor-pointer">
                                                + Create first brand
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <template x-for="brand in brands"
                                      :key="brand.id">
                                <tr class="cb-row group
                                            hover:bg-indigo-50/40
                                            dark:hover:bg-indigo-900/10
                                            transition-colors"
                                    :class="selectedId === brand.id
                                        ? 'selected' : ''"
                                    @click="editItem(brand)">

                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center
                                                    gap-2.5">
                                            <div class="w-8 h-8 rounded-lg
                                                        bg-purple-100
                                                        dark:bg-purple-900/40
                                                        flex items-center
                                                        justify-center
                                                        text-base
                                                        flex-shrink-0">
                                                🏷
                                            </div>
                                            <span class="text-sm font-semibold
                                                         text-gray-900
                                                         dark:text-white"
                                                  x-text="brand.name">
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3.5
                                               hidden md:table-cell">
                                        <span class="text-sm text-gray-500
                                                     dark:text-gray-400"
                                              x-text="brand.products_count
                                                  + ' products'">
                                        </span>
                                    </td>

                                    <td class="px-4 py-3.5">
                                        <span class="text-xs font-bold
                                                     px-2.5 py-1 rounded-full"
                                              :class="brand.is_active
                                                  ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                                                  : 'bg-gray-100 dark:bg-gray-800 text-gray-500'"
                                              x-text="brand.is_active
                                                  ? 'Active' : 'Inactive'">
                                        </span>
                                    </td>

                                    <td class="px-4 py-3.5"
                                        @click.stop>
                                        <div class="flex items-center
                                                    gap-1.5 opacity-0
                                                    group-hover:opacity-100
                                                    transition-opacity">
                                            <button type="button"
                                                    @click="editItem(brand)"
                                                    title="Edit"
                                                    class="w-7 h-7 rounded-lg
                                                           flex items-center
                                                           justify-center
                                                           bg-indigo-50
                                                           dark:bg-indigo-900/30
                                                           text-indigo-600
                                                           hover:bg-indigo-100
                                                           transition-colors
                                                           border-none
                                                           cursor-pointer">
                                                <svg class="w-3.5 h-3.5"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M11 5H6a2 2 0
                                                             00-2 2v11a2 2 0
                                                             002 2h11a2 2 0
                                                             002-2v-5m-1.414
                                                             -9.414a2 2 0
                                                             112.828 2.828
                                                             L11.828 15H9v
                                                             -2.828l8.586
                                                             -8.586z"/>
                                                </svg>
                                            </button>
                                            <button type="button"
                                                    @click="deleteItem(brand.id, brand.name)"
                                                    title="Delete"
                                                    class="w-7 h-7 rounded-lg
                                                           flex items-center
                                                           justify-center
                                                           bg-red-50
                                                           dark:bg-red-900/30
                                                           text-red-500
                                                           hover:bg-red-100
                                                           transition-colors
                                                           border-none
                                                           cursor-pointer">
                                                <svg class="w-3.5 h-3.5"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867
                                                             12.142A2 2 0
                                                             0116.138 21H7.862
                                                             a2 2 0 01-1.995
                                                             -1.858L5 7m5 4v6
                                                             m4-6v6m1-10V4a1
                                                             1 0 00-1-1h-4a1
                                                             1 0 00-1 1v3
                                                             M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            </template>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- RIGHT — Form Panel                        --}}
    {{-- ══════════════════════════════════════════ --}}
    <div class="w-full lg:w-80 xl:w-96 flex-shrink-0-">
        <div class="lg:sticky lg:top-5">

            {{-- Form --}}
            <div x-show="showForm"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white dark:bg-gray-900
                        border border-gray-200 dark:border-gray-700
                        rounded-2xl overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center justify-between px-5 py-4
                            bg-gray-50 dark:bg-gray-800
                            border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900
                                    dark:text-white"
                            x-text="editMode
                                ? 'Edit ' + (tab === 'categories'
                                    ? 'Category' : 'Brand')
                                : 'New ' + (tab === 'categories'
                                    ? 'Category' : 'Brand')">
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400
                                   mt-0.5"
                           x-text="editMode
                               ? 'Update details below'
                               : 'Fill in details below'">
                        </p>
                    </div>
                    <button type="button"
                            @click="closeForm()"
                            class="w-7 h-7 rounded-full flex items-center
                                   justify-center bg-gray-100
                                   dark:bg-gray-700 text-gray-500
                                   hover:bg-gray-200 hover:text-red-500
                                   transition-all border-none cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2.5"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Error --}}
                <div x-show="formError"
                     x-cloak
                     class="mx-5 mt-4 flex items-center gap-2 px-4 py-3
                            rounded-xl bg-red-50 dark:bg-red-900/20
                            border border-red-200 dark:border-red-800
                            text-red-700 dark:text-red-400
                            text-sm font-medium">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0
                                 9 9 0 0118 0z"/>
                    </svg>
                    <span x-text="formError"></span>
                </div>

                {{-- Fields --}}
                <div class="p-5 space-y-4">

                    {{-- Name --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Name
                            <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="text"
                               x-model="form.name"
                               x-ref="nameInput"
                               @keydown.enter.prevent="saveItem()"
                               placeholder="Enter name..."
                               class="w-full px-3.5 py-2.5 border
                                      rounded-xl text-sm outline-none
                                      bg-gray-50 dark:bg-gray-800
                                      text-gray-900 dark:text-white
                                      placeholder-gray-400
                                      focus:border-indigo-500
                                      focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900
                                      transition-all"
                               :class="formErrors.name
                                   ? 'border-red-400 dark:border-red-500'
                                   : 'border-gray-200 dark:border-gray-700'">
                        <p x-show="formErrors.name"
                           x-cloak
                           x-text="formErrors.name"
                           class="mt-1 text-xs text-red-500 font-medium">
                        </p>
                    </div>

                    {{-- Type (categories only) --}}
                    <div x-show="tab === 'categories'" x-cloak>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Type
                        </label>
                        <select x-model="form.type"
                                class="w-full px-3.5 py-2.5
                                       border border-gray-200 dark:border-gray-700
                                       rounded-xl text-sm outline-none
                                       bg-gray-50 dark:bg-gray-800
                                       text-gray-900 dark:text-white
                                       focus:border-indigo-500 transition-all
                                       cursor-pointer">
                            <option value="accessories">📦 Accessories</option>
                            <option value="repair">🔧 Repair</option>
                            <option value="both">✨ Both</option>
                        </select>
                    </div>

                    {{-- Sort Order --}}
                    <div>
                        <label class="block text-xs font-bold
                                       text-gray-500 dark:text-gray-400
                                       uppercase tracking-wider mb-1.5">
                            Sort Order
                        </label>
                        <input type="number"
                               x-model="form.sort_order"
                               min="0"
                               placeholder="0"
                               class="w-full px-3.5 py-2.5
                                      border border-gray-200 dark:border-gray-700
                                      rounded-xl text-sm outline-none
                                      bg-gray-50 dark:bg-gray-800
                                      text-gray-900 dark:text-white
                                      focus:border-indigo-500 transition-all">
                    </div>

                    {{-- Active toggle --}}
                    <div class="flex items-center justify-between pt-1">
                        <div>
                            <p class="text-sm font-semibold
                                       text-gray-900 dark:text-white">
                                Active
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Show in listings
                            </p>
                        </div>
                        <label class="relative inline-flex items-center
                                      cursor-pointer">
                            <input type="checkbox"
                                   x-model="form.is_active"
                                   class="sr-only peer">
                            <div class="w-11 h-6
                                        bg-gray-200 dark:bg-gray-700
                                        rounded-full peer transition-all
                                        peer-checked:bg-indigo-500
                                        after:content-['']
                                        after:absolute after:top-[2px]
                                        after:left-[2px] after:bg-white
                                        after:rounded-full after:h-5
                                        after:w-5 after:transition-all
                                        peer-checked:after:translate-x-5">
                            </div>
                        </label>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="px-5 pb-5 flex gap-3">
                    <button type="button"
                            @click="closeForm()"
                            class="flex-1 py-2.5 rounded-xl text-sm
                                   font-semibold border
                                   border-gray-200 dark:border-gray-700
                                   text-gray-600 dark:text-gray-400
                                   hover:bg-gray-50 dark:hover:bg-gray-800
                                   transition-all">
                        Cancel
                    </button>
                    <button type="button"
                            @click="saveItem()"
                            :disabled="isSaving"
                            class="flex-1 py-2.5 rounded-xl text-sm
                                   font-bold bg-indigo-600
                                   hover:bg-indigo-700
                                   disabled:opacity-60
                                   disabled:cursor-not-allowed
                                   active:scale-95 text-white transition-all
                                   flex items-center justify-center gap-2">
                        <svg x-show="isSaving"
                             x-cloak
                             class="w-4 h-4 animate-spin"
                             fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12"
                                    r="10" stroke="white" stroke-width="4"/>
                            <path class="opacity-75" fill="white"
                                  d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        <span x-text="isSaving ? 'Saving...'
                            : editMode ? 'Update' : 'Create'">
                        </span>
                    </button>
                </div>

            </div>

            {{-- Empty placeholder --}}
            <div x-show="!showForm"
                 class="bg-white dark:bg-gray-900
                        border-2 border-dashed
                        border-gray-300 dark:border-gray-700
                        rounded-2xl p-10 text-center">
                <div class="w-12 h-12 rounded-xl bg-indigo-50
                            dark:bg-indigo-900/30 flex items-center
                            justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-indigo-400" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-500
                           dark:text-gray-400 mb-1">
                    Click a row to edit
                </p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mb-4">
                    or create a new one
                </p>
                <button type="button"
                        @click="openCreate()"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold
                               bg-indigo-600 hover:bg-indigo-700
                               text-white transition-all">
                    <span x-text="'New ' + (tab === 'categories'
                        ? 'Category' : 'Brand')">
                    </span>
                </button>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
window.CAT_BRAND_ROUTES = {
    categories: {
        list   : '{{ route("categories.index") }}',
        store  : '{{ route("categories.store") }}',
        update : '/categories/{id}',
        destroy: '/categories/{id}',
    },
    brands: {
        list   : '{{ route("brands.index") }}',
        store  : '{{ route("brands.store") }}',
        update : '/brands/{id}',
        destroy: '/brands/{id}',
    },
};
</script>
<script src="{{ asset('js/cat-brand.js') }}"></script>
@endpush

</x-app-layout>