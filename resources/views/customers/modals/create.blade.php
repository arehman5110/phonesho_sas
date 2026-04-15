{{-- ============================================================ --}}
{{-- Reusable Add Customer Modal                                 --}}
{{-- Used in: Repairs, Sales, Buy&Sell, POS                     --}}
{{-- Triggered by: Alpine event 'open-add-customer-modal'        --}}
{{-- Emits: 'customer-created' with new customer data           --}}
{{-- ============================================================ --}}
<div x-data="AddCustomerModal()"
     @open-add-customer-modal.window="open()"
     @keydown.escape.window="close()"
     x-show="isOpen"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center
            justify-center p-4"
     style="display:none;background:rgba(15,23,42,0.75);">

    {{-- Modal Box --}}
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="close()"
         class="relative w-full max-w-md
                bg-white dark:bg-gray-900
                rounded-2xl shadow-2xl
                overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between
                    px-6 py-4
                    border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="text-base font-bold
                            text-gray-900 dark:text-white">
                    Add New Customer
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Customer will be saved to this shop
                </p>
            </div>
            <button type="button"
                    @click="close()"
                    class="w-8 h-8 rounded-full
                           flex items-center justify-center
                           bg-gray-100 dark:bg-gray-800
                           text-gray-500 dark:text-gray-400
                           hover:bg-gray-200 dark:hover:bg-gray-700
                           hover:text-red-500 dark:hover:text-red-400
                           transition-all border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 space-y-4">

            {{-- Error Alert --}}
            <div x-show="errorMessage"
                 x-transition
                 class="flex items-start gap-2.5 px-4 py-3
                        rounded-xl bg-red-50 dark:bg-red-900/20
                        border border-red-200 dark:border-red-800"
                 style="display:none;">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18
                             0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium text-red-700
                           dark:text-red-400"
                   x-text="errorMessage">
                </p>
            </div>

            {{-- Name --}}
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Full Name
                    <span class="text-red-500 ml-0.5">*</span>
                </label>
                <input type="text"
                       x-ref="nameInput"
                       x-model="form.name"
                       @keydown.enter.prevent="$refs.phoneInput.focus()"
                       placeholder="e.g. John Smith"
                       class="w-full px-3.5 py-2.5
                              border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none
                              bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white
                              placeholder-gray-400 dark:placeholder-gray-500
                              transition-all
                              focus:border-indigo-500 focus:ring-2
                              focus:ring-indigo-500/10
                              focus:bg-white dark:focus:bg-gray-900"
                       :class="errors.name
                           ? 'border-red-400 dark:border-red-600'
                           : ''">
                <p x-show="errors.name"
                   x-text="errors.name"
                   class="mt-1 text-xs text-red-500 font-medium">
                </p>
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Phone Number
                </label>
                <input type="tel"
                       x-ref="phoneInput"
                       x-model="form.phone"
                       @keydown.enter.prevent="$refs.emailInput.focus()"
                       placeholder="e.g. 07700 900000"
                       class="w-full px-3.5 py-2.5
                              border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none
                              bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white
                              placeholder-gray-400 dark:placeholder-gray-500
                              transition-all
                              focus:border-indigo-500 focus:ring-2
                              focus:ring-indigo-500/10
                              focus:bg-white dark:focus:bg-gray-900"
                       :class="errors.phone
                           ? 'border-red-400 dark:border-red-600'
                           : ''">
                <p x-show="errors.phone"
                   x-text="errors.phone"
                   class="mt-1 text-xs text-red-500 font-medium">
                </p>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Email Address
                </label>
                <input type="email"
                       x-ref="emailInput"
                       x-model="form.email"
                       @keydown.enter.prevent="$refs.addressInput.focus()"
                       placeholder="e.g. john@email.com"
                       class="w-full px-3.5 py-2.5
                              border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none
                              bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white
                              placeholder-gray-400 dark:placeholder-gray-500
                              transition-all
                              focus:border-indigo-500 focus:ring-2
                              focus:ring-indigo-500/10
                              focus:bg-white dark:focus:bg-gray-900"
                       :class="errors.email
                           ? 'border-red-400 dark:border-red-600'
                           : ''">
                <p x-show="errors.email"
                   x-text="errors.email"
                   class="mt-1 text-xs text-red-500 font-medium">
                </p>
            </div>

            {{-- Address --}}
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Address
                </label>
                <textarea x-ref="addressInput"
                          x-model="form.address"
                          rows="2"
                          placeholder="e.g. 123 High Street, London"
                          class="w-full px-3.5 py-2.5
                                 border border-gray-200 dark:border-gray-700
                                 rounded-xl text-sm outline-none
                                 bg-gray-50 dark:bg-gray-800
                                 text-gray-900 dark:text-white
                                 placeholder-gray-400 dark:placeholder-gray-500
                                 transition-all resize-none
                                 focus:border-indigo-500 focus:ring-2
                                 focus:ring-indigo-500/10
                                 focus:bg-white dark:focus:bg-gray-900">
                </textarea>
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6 flex gap-3">

            <button type="button"
                    @click="close()"
                    class="flex-1 py-2.5 rounded-xl text-sm font-semibold
                           border border-gray-200 dark:border-gray-700
                           text-gray-600 dark:text-gray-400
                           hover:bg-gray-50 dark:hover:bg-gray-800
                           transition-all">
                Cancel
            </button>

            <button type="button"
                    @click="save()"
                    :disabled="isSaving"
                    class="flex-1 py-2.5 rounded-xl text-sm font-bold
                           bg-indigo-600 hover:bg-indigo-700
                           disabled:opacity-60 disabled:cursor-not-allowed
                           active:scale-95 text-white transition-all
                           flex items-center justify-center gap-2">

                {{-- Loading spinner --}}
                <svg x-show="isSaving"
                     class="w-4 h-4 animate-spin"
                     fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12"
                            r="10" stroke="white" stroke-width="4"/>
                    <path class="opacity-75" fill="white"
                          d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>

                {{-- Check icon --}}
                <svg x-show="!isSaving"
                     class="w-4 h-4" fill="none" stroke="white"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>

                <span x-text="isSaving ? 'Saving...' : 'Save Customer'"></span>

            </button>

        </div>

    </div>
</div>

@pushOnce('scripts')
<script>
function AddCustomerModal() {
    return {
        // ── State ─────────────────────────────────
        isOpen  : false,
        isSaving: false,
        form: {
            name   : '',
            phone  : '',
            email  : '',
            address: '',
        },
        errors      : {},
        errorMessage: '',

        // ── Routes ────────────────────────────────
        routes: {
            store: '{{ route("customers.store") }}',
        },
        csrf: document.querySelector('meta[name="csrf-token"]')?.content,

        // ── Open ──────────────────────────────────
        open() {
            this.reset();
            this.isOpen = true;
            this.$nextTick(() => {
                this.$refs.nameInput?.focus();
            });
        },

        // ── Close ─────────────────────────────────
        close() {
            this.isOpen = false;
            this.reset();
        },

        // ── Reset ─────────────────────────────────
        reset() {
            this.form         = { name:'', phone:'', email:'', address:'' };
            this.errors       = {};
            this.errorMessage = '';
            this.isSaving     = false;
        },

        // ── Save ──────────────────────────────────
        async save() {
            // Client-side validation
            this.errors       = {};
            this.errorMessage = '';

            if (!this.form.name.trim()) {
                this.errors.name = 'Name is required.';
                this.$refs.nameInput?.focus();
                return;
            }

            this.isSaving = true;

            try {
                const res  = await fetch(this.routes.store, {
                    method  : 'POST',
                    headers : {
                        'Content-Type'     : 'application/json',
                        'X-CSRF-TOKEN'     : this.csrf,
                        'X-Requested-With' : 'XMLHttpRequest',
                        'Accept'           : 'application/json',
                    },
                    body: JSON.stringify(this.form),
                });

                const data = await res.json();

                if (data.success) {
                    // Dispatch to parent components
                    this.$dispatch('customer-created', data.customer);

                    // Show success toast
                    this._toast(`✓ ${data.message}`, 'success');

                    this.close();
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = Object.fromEntries(
                            Object.entries(data.errors).map(
                                ([k, v]) => [k, v[0]]
                            )
                        );
                        // Focus first error field
                        const firstKey = Object.keys(this.errors)[0];
                        if (firstKey && this.$refs[firstKey + 'Input']) {
                            this.$refs[firstKey + 'Input'].focus();
                        }
                    } else {
                        this.errorMessage = data.message
                            || 'Failed to save customer.';
                    }
                }

            } catch (e) {
                this.errorMessage = 'Network error. Please try again.';
                console.error('Save customer error:', e);
            } finally {
                this.isSaving = false;
            }
        },

        // ── Toast ─────────────────────────────────
        _toast(message, type = 'success') {
            const colors = {
                success: '#10b981',
                error  : '#ef4444',
                warning: '#f59e0b',
            };

            const el = document.createElement('div');
            el.style.cssText = `
                position:fixed;bottom:24px;right:24px;z-index:9999;
                padding:10px 18px;border-radius:12px;color:#fff;
                font-size:0.85rem;font-weight:700;
                box-shadow:0 8px 24px rgba(0,0,0,0.15);
                background:${colors[type] || colors.success};
                transform:translateY(10px);opacity:0;
                transition:all 0.25s ease;max-width:300px;`;
            el.textContent = message;
            document.body.appendChild(el);

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    el.style.transform = 'translateY(0)';
                    el.style.opacity   = '1';
                });
            });

            setTimeout(() => {
                el.style.opacity   = '0';
                el.style.transform = 'translateY(10px)';
                setTimeout(() => el.remove(), 250);
            }, 3500);
        },
    };
}
</script>
@endPushOnce