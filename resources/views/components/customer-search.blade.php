{{-- ============================================================ --}}
{{-- Reusable Customer Search Component                          --}}
{{-- Used in: Repairs, Sales, Buy&Sell                          --}}
{{-- Usage:                                                      --}}
{{-- <x-customer-search                                          --}}
{{--     :selected="$customer ?? null"                           --}}
{{--     input-name="customer_id"                                --}}
{{-- />                                                          --}}
{{-- ============================================================ --}}
@props([
    'selected'  => null,
    'inputName' => 'customer_id',
    'required'  => false,
])

<div x-data="CustomerSearch({{ $selected ? $selected->id : 'null' }},
                             '{{ $selected?->name ?? '' }}')"
     class="space-y-3">

    {{-- ── Search Row ──────────────────────────── --}}
    <div class="flex gap-3">

        {{-- Search Input --}}
        <div class="flex-1 relative">

            {{-- Search Icon --}}
            <svg class="absolute left-3 top-1/2 -translate-y-1/2
                        pointer-events-none w-4 h-4 text-gray-400
                        dark:text-gray-500"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>

            {{-- Text Input --}}
            <input type="text"
                   x-model="searchText"
                   x-ref="searchInput"
                   @input.debounce.300ms="search()"
                   @focus="onFocus()"
                   @keydown.escape="closeDropdown()"
                   @keydown.arrow-down.prevent="highlightNext()"
                   @keydown.arrow-up.prevent="highlightPrev()"
                   @keydown.enter.prevent="selectHighlighted()"
                   placeholder="Search by name, phone or email..."
                   autocomplete="off"
                   {{ $required ? 'required' : '' }}
                   class="w-full pl-9 pr-9 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          placeholder-gray-400 dark:placeholder-gray-500
                          transition-all duration-150
                          focus:border-indigo-500 dark:focus:border-indigo-500
                          focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900">

            {{-- Clear Button --}}
            <button type="button"
                    x-show="searchText"
                    @click="clear()"
                    class="absolute right-3 top-1/2 -translate-y-1/2
                           text-gray-400 hover:text-red-500
                           dark:hover:text-red-400
                           transition-colors p-0 bg-transparent
                           border-none cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Suggestions Dropdown --}}
            <div x-show="isOpen"
                 @click.away="closeDropdown()"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-1"
                 class="absolute top-full left-0 right-0 mt-1.5
                        bg-white dark:bg-gray-800
                        border border-gray-200 dark:border-gray-700
                        rounded-xl shadow-lg z-50
                        max-h-60 overflow-y-auto
                        scrollbar-thin"
                 style="display:none;">

                {{-- Loading --}}
                <div x-show="isLoading"
                     class="flex items-center gap-3 px-4 py-3
                            text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4 animate-spin flex-shrink-0"
                         fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12"
                                r="10" stroke="currentColor"
                                stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    Searching...
                </div>

                {{-- No Results --}}
                <div x-show="!isLoading && results.length === 0 && searchText.length > 0"
                     class="px-4 py-5 text-center">
                    <p class="text-sm font-semibold text-gray-500
                               dark:text-gray-400">
                        No customers found
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                        Try a different search or add a new customer
                    </p>
                </div>

                {{-- Results --}}
                <template x-for="(customer, index) in results"
                          :key="customer.id">
                    <div @click="select(customer)"
                         @mouseenter="highlightedIndex = index"
                         :class="highlightedIndex === index
                             ? 'bg-indigo-50 dark:bg-indigo-900/20'
                             : 'hover:bg-gray-50 dark:hover:bg-gray-700'"
                         class="flex items-center justify-between
                                gap-3 px-4 py-2.5 cursor-pointer
                                transition-colors border-b
                                border-gray-100 dark:border-gray-700
                                last:border-0">

                        <div class="flex items-center gap-3 min-w-0">

                            {{-- Avatar --}}
                            <div class="w-8 h-8 rounded-full bg-indigo-500
                                        flex items-center justify-center
                                        text-white text-xs font-bold
                                        flex-shrink-0"
                                 x-text="customer.name.charAt(0).toUpperCase()">
                            </div>

                            {{-- Info --}}
                            <div class="min-w-0">
                                <p class="text-sm font-semibold
                                           text-gray-900 dark:text-white
                                           truncate"
                                   x-text="customer.name">
                                </p>
                                <p class="text-xs text-gray-500
                                           dark:text-gray-400 truncate"
                                   x-text="[customer.phone, customer.email]
                                       .filter(Boolean).join(' · ')">
                                </p>
                            </div>

                        </div>

                        {{-- Balance --}}
                        <div class="flex-shrink-0">
                            <template x-if="parseFloat(customer.balance) > 0">
                                <span class="text-xs font-bold px-2 py-0.5
                                             rounded-full bg-red-100
                                             dark:bg-red-900/40
                                             text-red-600 dark:text-red-400"
                                      x-text="'£' + parseFloat(customer.balance).toFixed(2) + ' owed'">
                                </span>
                            </template>
                            <template x-if="parseFloat(customer.balance) <= 0">
                                <span class="text-xs font-semibold
                                             text-emerald-500 dark:text-emerald-400">
                                    ✓ Clear
                                </span>
                            </template>
                        </div>

                    </div>
                </template>

            </div>

        </div>

        {{-- Add Customer Button --}}
        <button type="button"
                @click="$dispatch('open-add-customer-modal')"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                       text-sm font-semibold flex-shrink-0
                       border-2 border-dashed
                       border-indigo-300 dark:border-indigo-700
                       text-indigo-600 dark:text-indigo-400
                       hover:bg-indigo-50 dark:hover:bg-indigo-900/20
                       transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="hidden sm:inline">New Customer</span>
            <span class="sm:hidden">New</span>
        </button>

    </div>

    {{-- Hidden input --}}
    <input type="hidden"
           :name="'{{ $inputName }}'"
           :value="selectedId">

    {{-- ── Customer Info Panel ─────────────────── --}}
    <div x-show="selectedCustomer"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="border border-gray-200 dark:border-gray-700
                rounded-xl overflow-hidden"
         style="display:none;">

        {{-- Customer Header --}}
        <div class="flex items-center justify-between px-4 py-3
                    bg-gray-50 dark:bg-gray-800">

            <div class="flex items-center gap-3">

                {{-- Avatar --}}
                <div class="w-9 h-9 rounded-full bg-indigo-500
                            flex items-center justify-center
                            text-white font-bold text-sm flex-shrink-0"
                     x-text="selectedCustomer?.name?.charAt(0)?.toUpperCase() ?? '?'">
                </div>

                {{-- Name & Contact --}}
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-white"
                       x-text="selectedCustomer?.name">
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400"
                       x-text="[selectedCustomer?.phone, selectedCustomer?.email]
                           .filter(Boolean).join(' · ')">
                    </p>
                </div>

            </div>

            {{-- Balance Badge --}}
            <template x-if="selectedCustomer &&
                             parseFloat(selectedCustomer.balance) > 0">
                <span class="text-xs font-bold px-2.5 py-1 rounded-full
                             bg-red-100 dark:bg-red-900/40
                             text-red-700 dark:text-red-400">
                    £<span x-text="parseFloat(selectedCustomer?.balance || 0)
                        .toFixed(2)"></span> owed
                </span>
            </template>

        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-3 divide-x divide-gray-200
                    dark:divide-gray-700">

            {{-- Total Spend --}}
            <div class="px-3 py-3 text-center">
                <p class="text-xs font-semibold text-gray-500
                           dark:text-gray-400 uppercase tracking-wider mb-1">
                    Spend
                </p>
                <p class="text-sm font-bold text-gray-900 dark:text-white"
                   x-text="stats
                       ? '£' + parseFloat(stats.total_spend || 0).toFixed(2)
                       : '...'">
                </p>
            </div>

            {{-- Total Repairs --}}
            <div class="px-3 py-3 text-center">
                <p class="text-xs font-semibold text-gray-500
                           dark:text-gray-400 uppercase tracking-wider mb-1">
                    Repairs
                </p>
                <div class="flex items-center justify-center gap-1.5">
                    <p class="text-sm font-bold text-gray-900 dark:text-white"
                       x-text="stats ? stats.total_repairs : '...'">
                    </p>
                    <template x-if="stats && stats.active_repairs > 0">
                        <span class="text-xs font-bold px-1.5 py-0.5
                                     rounded-full
                                     bg-amber-100 dark:bg-amber-900/40
                                     text-amber-700 dark:text-amber-400"
                              x-text="stats.active_repairs + ' active'">
                        </span>
                    </template>
                </div>
            </div>

            {{-- Balance --}}
            <div class="px-3 py-3 text-center">
                <p class="text-xs font-semibold text-gray-500
                           dark:text-gray-400 uppercase tracking-wider mb-1">
                    Balance
                </p>
                <p class="text-sm font-bold"
                   :class="parseFloat(selectedCustomer?.balance || 0) > 0
                       ? 'text-red-600 dark:text-red-400'
                       : 'text-emerald-600 dark:text-emerald-400'"
                   x-text="'£' + parseFloat(selectedCustomer?.balance || 0)
                       .toFixed(2)">
                </p>
            </div>

        </div>

        {{-- Address --}}
        <template x-if="selectedCustomer?.address">
            <div class="px-4 py-2 border-t border-gray-100
                        dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400
                           flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0
                                 01-2.827 0l-4.244-4.243a8 8 0 1111.314
                                 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span x-text="selectedCustomer.address"></span>
                </p>
            </div>
        </template>

    </div>

</div>

@pushOnce('scripts')
<script>
function CustomerSearch(initialId, initialName) {
    return {
        // ── State ─────────────────────────────────
        searchText       : initialName || '',
        selectedId       : initialId   || null,
        selectedCustomer : null,
        stats            : null,
        results          : [],
        isOpen           : false,
        isLoading        : false,
        highlightedIndex : -1,

        // ── Routes ────────────────────────────────
        routes: {
            search : '{{ route("customers.search") }}',
            stats  : '/api/customers/{id}/stats',
        },

        // ── Init ──────────────────────────────────
        init() {
            // Load initial customer if pre-selected
            if (this.selectedId) {
                this._loadInitialCustomer(this.selectedId);
            }

            // Listen for new customer created
            this.$el.addEventListener('customer-created', (e) => {
                this.select(e.detail);
            });
        },

        // ── Search ────────────────────────────────
        async search() {
            const term = this.searchText.trim();

            if (!term) {
                this.results  = [];
                this.isOpen   = false;
                return;
            }

            this.isLoading = true;
            this.isOpen    = true;

            try {
                const url = `${this.routes.search}?q=${encodeURIComponent(term)}`;
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                this.results          = await res.json();
                this.highlightedIndex = -1;
            } catch (e) {
                console.error('Customer search error:', e);
                this.results = [];
            } finally {
                this.isLoading = false;
            }
        },

        onFocus() {
            if (this.searchText.trim()) {
                this.search();
            }
        },

        // ── Select ────────────────────────────────
        async select(customer) {
            this.selectedId       = customer.id;
            this.selectedCustomer = customer;
            this.searchText       = customer.name
                + (customer.phone ? ` — ${customer.phone}` : '');
            this.isOpen           = false;
            this.results          = [];
            this.stats            = null;

            // Dispatch event for parent form
            this.$dispatch('customer-selected', customer);

            // Load full stats
            await this._loadStats(customer.id);
        },

        // ── Clear ─────────────────────────────────
        clear() {
            this.searchText       = '';
            this.selectedId       = null;
            this.selectedCustomer = null;
            this.stats            = null;
            this.results          = [];
            this.isOpen           = false;
            this.$dispatch('customer-cleared');
            this.$nextTick(() => this.$refs.searchInput?.focus());
        },

        closeDropdown() {
            this.isOpen           = false;
            this.highlightedIndex = -1;
        },

        // ── Keyboard navigation ───────────────────
        highlightNext() {
            if (!this.isOpen) return;
            this.highlightedIndex = Math.min(
                this.highlightedIndex + 1,
                this.results.length - 1
            );
        },

        highlightPrev() {
            if (!this.isOpen) return;
            this.highlightedIndex = Math.max(
                this.highlightedIndex - 1,
                -1
            );
        },

        selectHighlighted() {
            if (this.highlightedIndex >= 0 &&
                this.results[this.highlightedIndex]) {
                this.select(this.results[this.highlightedIndex]);
            }
        },

        // ── Load stats ────────────────────────────
        async _loadStats(customerId) {
            try {
                const url = this.routes.stats.replace('{id}', customerId);
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                this.stats = await res.json();

                // Update customer with fresh data
                if (this.selectedCustomer) {
                    this.selectedCustomer = {
                        ...this.selectedCustomer,
                        ...this.stats,
                    };
                }
            } catch (e) {
                console.error('Failed to load stats:', e);
            }
        },

        // ── Load initial customer ─────────────────
        async _loadInitialCustomer(id) {
            try {
                const url = this.routes.stats.replace('{id}', id);
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                this.selectedCustomer = data;
                this.stats            = data;
            } catch (e) {
                console.error('Failed to load initial customer:', e);
            }
        },
    };
}
</script>
@endPushOnce