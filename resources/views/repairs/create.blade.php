<x-app-layout>
    <x-slot name="title">Create Repair</x-slot>

    @push('styles')
        <style>
            .repair-input {
                width: 100%;
                padding: 4px 7px;
                border: 1.5px solid #e2e8f0;
                border-radius: 5px;
                font-size: 0.85rem;
                outline: none;
                /* background: #f8fafc; */
                color: #1e293b;
                transition: border 0.15s, box-shadow 0.15s;
                box-sizing: border-box;
            }

            .repair-input:focus {
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
                background: #fff;
            }

            .dark .repair-input {
                background: #1e293b;
                border-color: #334155;
                color: #e2e8f0;
            }

            .dark .repair-input:focus {
                border-color: #818cf8;
                background: #0f172a;
            }

            select.repair-input {
                cursor: pointer;
            }

            textarea.repair-input {
                resize: none;
            }
        </style>
    @endpush

    <form id="repairForm" method="POST" action="{{ route('repairs.store') }}" onsubmit="RepairForm.submit(event)">
        @csrf

        {{-- ── Page Header ─────────────────────────────── --}}
        <x-page-header title="New Repair Job" subtitle="Fill in the details below to create a new repair"
            :breadcrumbs="[
                ['label' => 'Dashboard', 'route' => 'dashboard'],
                ['label' => 'Repairs', 'route' => 'repairs.index'],
                ['label' => 'Create'],
            ]">
            <x-slot name="actions">
                <a href="{{ route('repairs.index') }}"
                    class="px-4 py-2 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800
                  transition-all">
                    Cancel
                </a>
            </x-slot>
        </x-page-header>

        {{-- ── Main Grid ────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- ════════════════════════════════════════════ --}}
            {{-- LEFT — Main Form (2/3 width)                --}}
            {{-- ════════════════════════════════════════════ --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- ── Customer Section ───────────────────── --}}
                <x-form-section title="Customer" color="blue">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12
                             14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </x-slot>
                    <x-customer-search input-name="customer_id" />
                </x-form-section>


                {{-- ── Warranty Return Toggle ─────────────────── --}}
                <div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden mb-0"
                    id="warranty-toggle-card">

                    <div class="flex items-center justify-between px-5 py-4">

                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg
                        bg-amber-100 dark:bg-amber-900/40
                        flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955
                             0 0112 2.944a11.955 11.955 0 01-8.618
                             3.04A12.02 12.02 0 003 9c0 5.591 3.824
                             10.29 9 11.622 5.176-1.332 9-6.03
                             9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    Warranty Return
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Is this repair a warranty return from a previous job?
                                </p>
                            </div>
                        </div>

                        {{-- Toggle Switch --}}
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="warranty-toggle" name="is_warranty_return" value="1"
                                class="sr-only peer" onchange="WarrantyReturn.toggle(this.checked)">
                            <div
                                class="w-11 h-6 bg-gray-200 dark:bg-gray-700
                        peer-focus:ring-2 peer-focus:ring-amber-400
                        rounded-full peer
                        peer-checked:bg-amber-500
                        transition-all after:content-['']
                        after:absolute after:top-[2px] after:left-[2px]
                        after:bg-white after:rounded-full
                        after:h-5 after:w-5 after:transition-all
                        peer-checked:after:translate-x-5">
                            </div>
                        </label>

                    </div>

                    {{-- Warranty Search Panel (hidden by default) --}}
                    <div id="warranty-search-panel" style="display:none;"
                        class="border-t border-gray-200 dark:border-gray-700
                px-5 py-4 bg-amber-50/50 dark:bg-amber-900/10">

                        {{-- Hidden inputs --}}
                        <input type="hidden" id="parent-repair-id" name="parent_repair_id">

                        {{-- Search Input --}}
                        <div class="relative mb-3">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2
                        w-4 h-4 text-gray-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                            </svg>
                            <input type="text" id="warranty-search-input"
                                placeholder="Search by IMEI, Repair ID or customer name..." autocomplete="off"
                                oninput="WarrantyReturn.search(this.value)"
                                class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-white dark:bg-gray-800
                          text-gray-900 dark:text-white
                          placeholder-gray-400
                          focus:border-amber-400
                          focus:ring-2 focus:ring-amber-400/10
                          transition-all">

                            {{-- Loading --}}
                            <div id="warranty-search-loading" style="display:none;"
                                class="absolute right-3 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4 animate-spin text-amber-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                </svg>
                            </div>
                        </div>

                        {{-- Search Results --}}
                        <div id="warranty-search-results" style="display:none;"
                            class="bg-white dark:bg-gray-800
                    border border-gray-200 dark:border-gray-700
                    rounded-xl overflow-hidden mb-3
                    shadow-lg">
                        </div>

                        {{-- Selected Repair Details --}}
                        <div id="warranty-selected-repair" style="display:none;">
                        </div>

                    </div>
                </div>

                {{-- ── Repair Details ──────────────────────── --}}
                <x-form-section title="Repair Details" color="purple">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2
                             2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0
                             002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2
                             2 0 012 2" />
                        </svg>
                    </x-slot>

                    <div class="grid grid-cols-1 sm:grid-cols-2
                        lg:grid-cols-3 gap-4">

                        {{-- Status --}}
                        <div>
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Status
                            </label>
                            <select name="status_id" class="repair-input">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->is_default ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Book-in Date --}}
                        <div>
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Book-in Date
                            </label>
                            <input type="date" name="book_in_date" value="{{ date('Y-m-d') }}"
                                class="repair-input">
                        </div>

                        {{-- Completion Date --}}
                        <div>
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Est. Completion
                            </label>
                            <input type="date" name="completion_date" class="repair-input">
                        </div>

                        {{-- Delivery Type --}}
                        <div>
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Delivery Type
                            </label>
                            <select name="delivery_type" class="repair-input">
                                <option value="collection">🏪 Collection</option>
                                <option value="delivery">🚚 Delivery</option>
                            </select>
                        </div>

                        {{-- Assigned To --}}
                        <div>
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Assigned To
                            </label>
                            <select name="assigned_to" class="repair-input">
                                <option value="">Unassigned</option>
                                @foreach ($staff as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Discount (hidden — controlled by JS) --}}
                        <input type="hidden" name="discount" id="repair-discount-hidden" value="0">

                        {{-- Notes --}}
                        <div class="sm:col-span-2 lg:col-span-3">
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Internal Notes
                            </label>
                            <textarea name="notes" rows="3" placeholder="Internal notes..." class="repair-input">
                    </textarea>
                        </div>

                    </div>
                </x-form-section>

                {{-- ── Devices Section ─────────────────────── --}}
                <x-form-section title="Devices" color="green">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0
                             00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </x-slot>
                    <x-slot name="badgeSlot">
                        <span id="deviceCount"
                            class="text-xs font-bold px-2 py-0.5
                             rounded-full bg-green-100
                             dark:bg-green-900/40
                             text-green-700 dark:text-green-400">
                            0 devices
                        </span>
                    </x-slot>

                    {{-- Device Cards --}}
                    <div id="devicesContainer" class="space-y-4 mb-4">
                        <div id="devicesEmpty"
                            class="flex flex-col items-center
                            justify-center py-10
                            text-gray-400 dark:text-gray-600">
                            <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2
                                 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0
                                 002 2z" />
                            </svg>
                            <p class="text-sm font-semibold">No devices added</p>
                            <p class="text-xs mt-1">Click "Add Device" to start</p>
                        </div>
                    </div>

                    {{-- Add Device Button --}}
                    <button type="button" onclick="RepairForm.addDevice()"
                        class="w-full py-3 rounded-xl text-sm font-bold
                           border-2 border-dashed
                           border-green-300 dark:border-green-800
                           text-green-600 dark:text-green-500
                           hover:bg-green-50 dark:hover:bg-green-900/20
                           transition-all flex items-center
                           justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Add Device
                    </button>

                </x-form-section>

            </div>

            {{-- ════════════════════════════════════════════ --}}
            {{-- RIGHT — Payment Panel                       --}}
            {{-- ════════════════════════════════════════════ --}}
            @include('repairs.partials.right-panel')

        </div>
    </form>

    {{-- ── Modals ───────────────────────────────────── --}}
    @include('customers.modals.create')
    @include('repairs.partials.modals.discount')
    @include('repairs.partials.modals.payment')

    @push('scripts')
        {{-- Config must come before repair scripts --}}
        <script>
            window.REPAIR_CONFIG = {
                routes: {
                    repairTypes: '{{ route('repair-types.search') }}',
                    products: '{{ route('products.search') }}',
                    customers: '{{ route('customers.search') }}',
                    customerStats: '/api/customers/{id}/stats',
                    customerStore: '{{ route('customers.store') }}',
                },
                csrf: '{{ csrf_token() }}',
            };

            // Device card template for JS cloning
            window.__DEVICE_TEMPLATE__ = @json($deviceCardTemplate);
        </script>

        {{-- Payment panel (stays as separate file) --}}
        <script src="{{ asset('js/repair-form.js') }}"></script>

        {{-- Modular repair form --}}
        @vite('resources/js/repair/index.js')
    @endpush

</x-app-layout>
