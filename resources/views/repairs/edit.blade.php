<x-app-layout>
<x-slot name="title">Edit {{ $repair->reference }}</x-slot>

@push('styles')
<style>
    .repair-input {
        width: 100%;
        padding: 4px 7px;
        border: 1.5px solid #e2e8f0;
        border-radius: 5px;
        font-size: 0.85rem;
        outline: none;
        color: #1e293b;
        transition: border 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
    }
    .repair-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        background: #fff;
    }
    .dark .repair-input { background: #1e293b; border-color: #334155; color: #e2e8f0; }
    .dark .repair-input:focus { border-color: #818cf8; background: #0f172a; }
    select.repair-input { cursor: pointer; }
    textarea.repair-input { resize: none; }
    @keyframes shake {
        0%,100% { transform: translateX(0); }
        20%     { transform: translateX(-6px); }
        40%     { transform: translateX(6px); }
        60%     { transform: translateX(-4px); }
        80%     { transform: translateX(4px); }
    }
</style>
@endpush

<form id="repairForm" method="POST"
      action="{{ route('repairs.update', $repair) }}"
      onsubmit="RepairForm.submit(event)">
@csrf
@method('PUT')

{{-- existing_device_ids injected by JS --}}

<x-page-header
    title="Edit {{ $repair->reference }}"
    subtitle="Update all repair details"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Repairs',   'route' => 'repairs.index'],
        ['label' => $repair->reference, 'route' => 'repairs.show', 'params' => $repair],
        ['label' => 'Edit'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('repairs.show', $repair) }}"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            ← Back
        </a>
    </x-slot>
</x-page-header>

@if($errors->any())
<div class="flex items-start gap-3 px-4 py-3 rounded-xl mb-5
            bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none"
         stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <ul class="text-sm text-red-700 dark:text-red-400 space-y-0.5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ══════════════════════ LEFT (2/3) ══════════════════════ --}}
    <div class="lg:col-span-2 space-y-4">

        {{-- ── Customer Section ────────────────────── --}}
        <x-form-section title="Customer" color="blue">
            <x-slot name="icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </x-slot>
            <x-customer-search input-name="customer_id" />
        </x-form-section>

        {{-- ── Repair Details ───────────────────────── --}}
        <x-form-section title="Repair Details" color="purple">
            <x-slot name="icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0
                             00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </x-slot>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- Book-in Date --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500
                                   dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Book-in Date
                    </label>
                    <input type="date" name="book_in_date"
                           value="{{ $repair->book_in_date?->format('Y-m-d') }}"
                           class="repair-input">
                </div>

                {{-- Est. Completion --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500
                                   dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Est. Completion
                    </label>
                    <input type="date" name="completion_date"
                           value="{{ $repair->completion_date?->format('Y-m-d') }}"
                           class="repair-input">
                </div>

                {{-- Delivery Type --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500
                                   dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Delivery Type
                    </label>
                    <select name="delivery_type" class="repair-input">
                        <option value="collection" {{ $repair->delivery_type === 'collection' ? 'selected' : '' }}>
                            🏪 Collection
                        </option>
                        <option value="delivery" {{ $repair->delivery_type === 'delivery' ? 'selected' : '' }}>
                            🚚 Delivery
                        </option>
                    </select>
                </div>

                {{-- Discount — hidden, controlled by JS discount modal --}}
                <input type="hidden" name="discount" id="repair-discount-hidden"
                       value="{{ $repair->discount }}">

                {{-- Notes --}}
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="block text-xs font-semibold text-gray-500
                                   dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Internal Notes
                    </label>
                    <textarea name="notes" rows="3" placeholder="Internal notes..."
                              class="repair-input">{{ $repair->notes }}</textarea>
                </div>

            </div>
        </x-form-section>

        {{-- ── Devices Section ─────────────────────── --}}
        <x-form-section title="Devices" color="green">
            <x-slot name="icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0
                             00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </x-slot>
            <x-slot name="badgeSlot">
                <span id="deviceCount"
                      class="text-xs font-bold px-2 py-0.5 rounded-full
                             bg-green-100 dark:bg-green-900/40
                             text-green-700 dark:text-green-400">
                    {{ $repair->devices->count() }} devices
                </span>
            </x-slot>

            <div id="devicesContainer" class="space-y-4 mb-4">
                <div id="devicesEmpty"
                     class="flex flex-col items-center justify-center py-10
                            text-gray-400 dark:text-gray-600"
                     style="{{ $repair->devices->count() > 0 ? 'display:none;' : '' }}">
                    <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0
                                 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm font-semibold">No devices added</p>
                    <p class="text-xs mt-1">Click "Add Device" to start</p>
                </div>

                {{-- Devices injected by JS after RepairForm loads --}}
            </div>

            <button type="button" onclick="RepairForm.addDevice()"
                    class="w-full py-3 rounded-xl text-sm font-bold
                           border-2 border-dashed border-green-300 dark:border-green-800
                           text-green-600 dark:text-green-500
                           hover:bg-green-50 dark:hover:bg-green-900/20
                           transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Device
            </button>

        </x-form-section>

    </div>

    {{-- ══════════════════════ RIGHT — Payment Panel ══════════════════════ --}}
    @include('repairs.partials.right-panel')

</div>
</form>

{{-- Modals --}}
@include('customers.modals.create')
@include('repairs.partials.modals.discount')
@include('repairs.partials.modals.payment')

@push('scripts')
<script>
window.REPAIR_CONFIG = {
    routes: {
        repairTypes   : '{{ route("repair-types.search") }}',
        products      : '{{ route("products.search") }}',
        customers     : '{{ route("customers.search") }}',
        customerStats : '/api/customers/{id}/stats',
        customerStore : '{{ route("customers.store") }}',
        customerUpdate: '/api/customers/{id}',
    },
    csrf: '{{ csrf_token() }}',
};
window.__DEVICE_TEMPLATE__ = @json($deviceCardTemplate);
</script>

<script src="{{ asset('js/repair-form.js') }}"></script>
@vite('resources/js/repair/index.js')

<script>
// Existing device data to pre-fill after JS boots
const _EXISTING_DEVICES = @json($existingDevicesData);

// Wait until repair/index.js has registered window.RepairForm and window.PartsInput
// We poll until they're available, then add devices programmatically
(function waitForRepairForm() {
    if (!window.RepairForm || !window.PartsInput || !window.Alpine) {
        return setTimeout(waitForRepairForm, 50);
    }
    _initEditForm();
})();

function _initEditForm() {

    // ── 1. Add each device via RepairForm.addDevice() ─────────
    // This is identical to what the create form does, so Alpine
    // evaluates x-data AFTER window.PartsInput is registered
    _EXISTING_DEVICES.forEach((d, idx) => {
        RepairForm.addDevice();

        // After addDevice, the new card is the last one in the container
        requestAnimationFrame(() => {
            const cards = document.querySelectorAll('#devicesContainer .device-card');
            const card  = cards[cards.length - 1];
            if (!card) return;

            const index = card.dataset.deviceIndex;

            // ── Hidden existing_device_id ──────────────────────
            const h  = document.createElement('input');
            h.type   = 'hidden';
            h.name   = `devices[${index}][existing_device_id]`;
            h.value  = d.id;
            card.appendChild(h);

            // ── Simple inputs ──────────────────────────────────
            _set(card, `input[name="devices[${index}][device_name]"]`,      d.device_name);
            _set(card, `select[name="devices[${index}][device_type_id]"]`,   d.device_type_id);
            _set(card, `select[name="devices[${index}][status_id]"]`,        d.status_id);
            _set(card, `input[name="devices[${index}][imei]"]`,              d.imei);
            _set(card, `input[name="devices[${index}][color]"]`,             d.color);
            _set(card, `input[name="devices[${index}][price]"]`,             d.price);
            _set(card, `textarea[name="devices[${index}][notes]"]`,          d.notes);

            // ── Warranty ──────────────────────────────────────
            const wVal = d.warranty_status === 'under_warranty' ? -1
                       : (d.warranty_days ?? 0);
            _set(card, `select[name="devices[${index}][warranty_days]"]`, wVal);
            const wsInput = card.querySelector(`input[name="devices[${index}][warranty_status]"]`);
            if (wsInput) wsInput.value = d.warranty_status ?? 'active';

            // ── Alpine PartsInput components ───────────────────
            // Must wait for Alpine.initTree() to finish on the card
            // (addDevice already calls Alpine.initTree after 250ms)
            setTimeout(() => {
                if (d.issue) {
                    _fillAlpine(card, `devices[${index}][issues]`,
                        d.issue.split(',').map(s => ({ name: s.trim() })).filter(t => t.name));
                }
                if (d.repair_type) {
                    _fillAlpine(card, `devices[${index}][repair_type_tags]`,
                        d.repair_type.split(',').map(s => ({ name: s.trim() })).filter(t => t.name));
                }
                if (d.parts?.length) {
                    _fillAlpine(card, `devices[${index}][parts]`, d.parts);
                }
                if (window.RepairPayments) RepairPayments.updateTotals();
            }, 350);
        });
    });

    // ── 2. Customer ────────────────────────────────────────────
    @if($repair->customer)
    setTimeout(() => {
        document.dispatchEvent(new CustomEvent('customer-created', {
            detail: {
                id   : {{ $repair->customer->id }},
                name : @json($repair->customer->name),
                phone: @json($repair->customer->phone ?? ''),
                email: @json($repair->customer->email ?? ''),
            }
        }));
    }, 100);
    @endif

    // ── 3. Discount ────────────────────────────────────────────
    @if((float)$repair->discount > 0)
    setTimeout(() => {
        if (window.RepairPayments?.setDiscountFromEdit) {
            RepairPayments.setDiscountFromEdit({{ (float)$repair->discount }});
        }
    }, 200);
    @endif
}

// Set a field value safely
function _set(card, selector, value) {
    if (value === null || value === undefined || value === '') return;
    const el = card.querySelector(selector);
    if (el) el.value = value;
}

// Fill an Alpine PartsInput component by matching its inputName
function _fillAlpine(card, inputName, items) {
    if (!items?.length) return;
    card.querySelectorAll('[x-data]').forEach(root => {
        if (!root.getAttribute('x-data')?.includes('PartsInput')) return;
        try {
            const data = Alpine.$data(root);
            if (!data || data.inputName !== inputName) return;
            if (typeof data.prefill === 'function') {
                data.prefill(items);
            } else {
                data.parts = items.map(i => ({
                    name      : i.name ?? String(i),
                    product_id: i.product_id ?? null,
                    quantity  : i.quantity  ?? 1,
                    price     : i.price     ?? 0,
                    isCustom  : i.isCustom  ?? !i.product_id,
                }));
            }
        } catch(e) {}
    });
}
</script>
@endpush

</x-app-layout>