



<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'fieldName' => 'customer_id',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'fieldName' => 'customer_id',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="CustomerSearch()"
     x-init="init()"
     class="relative space-y-3">

    
    <input type="hidden"
           name="<?php echo e($fieldName); ?>"
           x-model="selectedId">

    
    <div class="flex items-center gap-2">

        
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2
                        w-4 h-4 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text"
                   x-ref="searchInput"
                   x-model="searchVal"
                   @input.debounce.300ms="search()"
                   @focus="onFocus()"
                   @keydown.escape="clear()"
                   @keydown.enter.prevent="selectHighlighted()"
                   @keydown.arrow-down.prevent="moveDown()"
                   @keydown.arrow-up.prevent="moveUp()"
                   placeholder="Search customer by name or phone..."
                   autocomplete="off"
                   class="w-full pl-9 pr-9 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          placeholder-gray-400
                          focus:border-indigo-500
                          focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900
                          transition-all">

            
            <button type="button"
                    x-show="searchVal"
                    @click="clear()"
                    class="absolute right-3 top-1/2 -translate-y-1/2
                           text-gray-400 hover:text-red-500
                           bg-transparent border-none cursor-pointer
                           transition-colors p-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        
        <button type="button"
                @click="$dispatch('open-add-customer-modal')"
                title="Add new customer"
                class="flex-shrink-0 w-9 h-9 rounded-xl
                       bg-indigo-600 hover:bg-indigo-700
                       text-white flex items-center justify-center
                       transition-all active:scale-95
                       border-none cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
        </button>

    </div>

    
    <div x-show="isOpen && (results.length > 0 || searchVal.length > 1)"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         @click.outside="isOpen = false"
         class="absolute top-11 left-0 right-9 mt-0
                bg-white dark:bg-gray-800
                border border-gray-200 dark:border-gray-700
                rounded-xl shadow-xl z-50
                max-h-64 overflow-y-auto"
         style="display:none;">

        
        <template x-for="(customer, index) in results" :key="customer.id">
            <div @mousedown.prevent="select(customer)"
                 class="flex items-center justify-between
                        px-4 py-2.5 cursor-pointer transition-colors
                        border-b border-gray-100 dark:border-gray-700
                        last:border-0"
                 :class="highlightedIndex === index
                     ? 'bg-indigo-50 dark:bg-indigo-900/20'
                     : 'hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-7 h-7 rounded-full flex items-center
                                justify-center text-xs font-bold
                                bg-indigo-100 dark:bg-indigo-900/60
                                text-indigo-600 dark:text-indigo-400
                                flex-shrink-0"
                         x-text="customer.name.charAt(0).toUpperCase()">
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold truncate
                                   text-gray-900 dark:text-white"
                           x-text="customer.name">
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500"
                           x-text="[customer.phone, customer.email]
                               .filter(Boolean).join(' · ')">
                        </p>
                    </div>
                </div>
            </div>
        </template>

        
        <div x-show="results.length === 0 && searchVal.trim().length > 1 && !isLoading"
             class="px-4 py-3 text-sm text-center
                    text-gray-500 dark:text-gray-400">
            No customers found
        </div>

    </div>

    
    <div x-show="selectedId"
         x-transition
         class="p-4 rounded-xl
                bg-indigo-50 dark:bg-indigo-900/20
                border border-indigo-200 dark:border-indigo-800"
         style="display:none;">
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full flex items-center
                            justify-center text-sm font-black
                            bg-indigo-600 text-white flex-shrink-0"
                     x-text="selectedCustomer?.name?.charAt(0)?.toUpperCase()">
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-indigo-900
                               dark:text-indigo-200"
                       x-text="selectedCustomer?.name">
                    </p>
                    <p class="text-xs text-indigo-600 dark:text-indigo-400"
                       x-text="[selectedCustomer?.phone, selectedCustomer?.email]
                                .filter(Boolean).join(' · ')">
                    </p>
                    <p x-show="selectedCustomer?.address"
                       class="text-xs text-indigo-500 dark:text-indigo-400 mt-0.5 truncate"
                       x-text="selectedCustomer?.address">
                    </p>
                    
                    <p x-show="selectedCustomer?.notes"
                       class="text-xs text-indigo-500 dark:text-indigo-400 mt-1 italic"
                       x-text="'📝 ' + selectedCustomer?.notes">
                    </p>
                </div>
            </div>

            
            <button type="button"
                    @click="$dispatch('open-edit-customer-modal', selectedCustomer)"
                    title="Edit customer"
                    class="flex items-center gap-1 px-2.5 py-1.5
                           rounded-lg text-xs font-semibold
                           bg-indigo-100 dark:bg-indigo-900/60
                           text-indigo-600 dark:text-indigo-400
                           hover:bg-indigo-200 dark:hover:bg-indigo-900
                           transition-colors border-none cursor-pointer
                           flex-shrink-0">
                <svg class="w-3.5 h-3.5" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2
                             2 0 002-2v-5m-1.414-9.414a2 2 0 112.828
                             2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </button>
        </div>

        
        <div class="mt-3 pt-3 border-t border-indigo-200 dark:border-indigo-800
                    flex items-center gap-3 flex-wrap">

            
            <template x-if="statsLoading">
                <span class="text-xs text-indigo-400">Loading stats...</span>
            </template>

            
            <template x-if="!statsLoading && customerStats">
                <div class="flex items-center gap-3 flex-wrap w-full">

                    
                    <div class="flex flex-col">
                        <span class="text-sm font-black text-emerald-600 dark:text-emerald-400"
                              x-text="'£' + parseFloat(customerStats.total_spent || 0).toFixed(2) + ' spent'">
                        </span>
                        <span class="text-xs font-semibold"
                              :class="parseFloat(customerStats.balance || 0) > 0
                                  ? 'text-red-500 dark:text-red-400'
                                  : 'text-gray-400 dark:text-gray-500'"
                              x-text="parseFloat(customerStats.balance || 0) > 0
                                  ? '£' + parseFloat(customerStats.balance).toFixed(2) + ' balance due'
                                  : 'No balance due'">
                        </span>
                    </div>

                    
                    <div class="flex-1"></div>

                    
                    <a :href="'/repairs?search=' + encodeURIComponent(selectedCustomer?.phone || selectedCustomer?.name || '')"
                       target="_blank"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                              text-xs font-bold border border-indigo-300 dark:border-indigo-700
                              text-indigo-600 dark:text-indigo-400
                              bg-white dark:bg-indigo-900/30
                              hover:bg-indigo-50 dark:hover:bg-indigo-900/50
                              transition-colors">
                        <span x-text="(customerStats.total_repairs || 0) + ' Job' + (customerStats.total_repairs !== 1 ? 's' : '')"></span>
                        <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4
                                     M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>

                </div>
            </template>

        </div>
    </div>

</div>

<?php if (! $__env->hasRenderedOnce('84d0fca9-faeb-4e2b-a593-012e1f2e00f4')): $__env->markAsRenderedOnce('84d0fca9-faeb-4e2b-a593-012e1f2e00f4'); ?>
<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('CustomerSearch', () => ({
        searchVal        : '',
        selectedId       : '',
        selectedCustomer : null,
        customerStats    : null,
        statsLoading     : false,
        results          : [],
        isOpen           : false,
        isLoading        : false,
        highlightedIndex : -1,

        init() {
            // New customer created via modal
            document.addEventListener('customer-created', (e) => {
                this.select(e.detail);
            });

            // Customer updated via edit modal
            document.addEventListener('customer-updated', (e) => {
                if (String(e.detail.id) === String(this.selectedId)) {
                    this.selectedCustomer = e.detail;
                    this.searchVal        = e.detail.name;
                }
                const el = document.getElementById('infoCustomer');
                if (el) el.textContent = e.detail.name;
            });

            // Close dropdown on outside click
            document.addEventListener('click', (e) => {
                if (!this.$el.contains(e.target)) {
                    this.isOpen = false;
                }
            });
        },

        async search() {
            const val = this.searchVal.trim();
            if (!val) { this.isOpen = false; return; }

            this.isLoading = true;
            this.isOpen    = true;

            try {
                const url = (window.REPAIR_CONFIG?.routes?.customers
                    ?? '/api/customers/search')
                    + '?q=' + encodeURIComponent(val);

                const res    = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                this.results          = await res.json();
                this.highlightedIndex = -1;
            } catch (e) {
                this.results = [];
            } finally {
                this.isLoading = false;
            }
        },

        onFocus() {
            if (this.searchVal.trim().length > 0) {
                this.isOpen = true;
            }
        },

        async select(customer) {
            this.selectedId       = customer.id;
            this.selectedCustomer = customer;
            this.searchVal        = customer.name;
            this.isOpen           = false;
            this.customerStats    = null;

            const el = document.getElementById('infoCustomer');
            if (el) el.textContent = customer.name;

            document.dispatchEvent(new CustomEvent('customer-selected', {
                detail: customer
            }));

            // Fetch customer stats
            this.statsLoading = true;
            try {
                const statsUrl = (window.REPAIR_CONFIG?.routes?.customerStats
                    ?? '/api/customers/{id}/stats').replace('{id}', customer.id);
                const res = await fetch(statsUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                this.customerStats = await res.json();
            } catch(e) {
                this.customerStats = null;
            } finally {
                this.statsLoading = false;
            }
        },

        clear() {
            this.selectedId       = '';
            this.selectedCustomer = null;
            this.customerStats    = null;
            this.searchVal        = '';
            this.isOpen           = false;
            this.results          = [];

            const el = document.getElementById('infoCustomer');
            if (el) el.textContent = 'None';

            document.dispatchEvent(new CustomEvent('customer-cleared'));
        },

        selectHighlighted() {
            if (this.highlightedIndex >= 0 && this.results[this.highlightedIndex]) {
                this.select(this.results[this.highlightedIndex]);
            }
        },

        moveDown() {
            this.highlightedIndex = Math.min(
                this.highlightedIndex + 1,
                this.results.length - 1
            );
        },

        moveUp() {
            this.highlightedIndex = Math.max(
                this.highlightedIndex - 1, -1
            );
        },
    }));
});
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/components/customer-search.blade.php ENDPATH**/ ?>