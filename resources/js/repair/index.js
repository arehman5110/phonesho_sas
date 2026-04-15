/**
 * Repair Form — Entry Point
 * Imports all modules and wires everything together
 */

// ── Module imports ────────────────────────────────
import { _toast }                            from './uiHelpers.js';
import { updateWarrantyExpiry }              from './warrantyManager.js';
import { RepairTypeInput }                   from './repairTypeInput.js';
import { PartsInput }                        from './partsManager.js';
import { addDevice, removeDevice }           from './deviceManager.js';

import {
    initDiscount,
    updateTotals,
    getTotal,
    openDiscountModal,
    closeDiscountModal,
    setDiscountType,
    setQuickDiscount,
    updateDiscountPreview,
    applyDiscount,
    removeDiscount,
} from './discountManager.js';

import {
    initPayment,
    openPaymentModal,
    closePaymentModal,
    onMethodChange,
    selectMethod,
    setQuickAmount,
    setExactAmount,
    updateChange,
    updateSplit2,
    addPayment,
    removePayment,
    clearPayments,
} from './paymentManager.js';

// ── Shared state ──────────────────────────────────
// Single source of truth — passed to each module
const state = {
    subtotal       : 0,
    discountAmount : 0,
    discountType   : 'percent',
    payments       : [],
    selectedMethod : 'cash',
};

// ── Initialize modules with shared state ─────────
initDiscount(state);
initPayment(state);

// ── Register Alpine globals ───────────────────────
window.PartsInput      = PartsInput;
window.RepairTypeInput = RepairTypeInput;

// ── Register window.RepairPayments ───────────────
// Called from Blade onclick handlers + right-panel
window.RepairPayments = {
    // Totals
    updateTotals,
    // Warranty
    updateWarrantyExpiry,
    // Discount
    openDiscountModal,
    closeDiscountModal,
    setDiscountType,
    setQuickDiscount,
    updateDiscountPreview,
    applyDiscount,
    removeDiscount,
    // Payment
    openPaymentModal,
    closePaymentModal,
    onMethodChange,
    setQuickAmount,
    setExactAmount,
    updateChange,
    updateSplit2,
    addPayment,
    removePayment,
    clearPayments,
};

// ── Register window.RepairForm ────────────────────
// Called from device card + form submit handlers
window.RepairForm = {

    init() {
        // Customer search events
        document.addEventListener('customer-selected', (e) => {
            const el = document.getElementById('infoCustomer');
            if (el) el.textContent = e.detail.name;
        });

        document.addEventListener('customer-cleared', () => {
            const el = document.getElementById('infoCustomer');
            if (el) el.textContent = 'None';
        });

        document.addEventListener('customer-created', (e) => {
            const el = document.getElementById('infoCustomer');
            if (el) el.textContent = e.detail.name;
        });

        // Price/discount input changes → update totals
        document.addEventListener('input', (e) => {
            if (e.target.matches('input[name$="[price]"]') ||
                e.target.matches('input[name="discount"]')) {
                updateTotals();
            }
        });

        // Escape key closes modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeDiscountModal();
                closePaymentModal();
            }
        });

        // Overlay click closes modals
        document.getElementById('repair-discount-modal')
            ?.addEventListener('click', (e) => {
                if (e.target === e.currentTarget) closeDiscountModal();
            });

        document.getElementById('repair-payment-modal')
            ?.addEventListener('click', (e) => {
                if (e.target === e.currentTarget) closePaymentModal();
            });

        // Initial totals calculation
        updateTotals();
    },

    addDevice() {
        const template = window.__DEVICE_TEMPLATE__;
        if (!template) { console.error('Device template not found'); return; }
        addDevice(template);
    },

    removeDevice(btn) {
        removeDevice(btn);
    },

    updateWarrantyExpiry(input) {
        updateWarrantyExpiry(input);
    },

    updateTotals() {
        updateTotals();
    },

    submit(e) {
        e.preventDefault();

        if (!document.querySelectorAll('.device-card').length) {
            _toast('Please add at least one device.', 'error');
            return;
        }

        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.disabled  = true;
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="white"
                            stroke-width="4" opacity="0.25"/>
                    <path fill="white" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                Saving...`;
        }

        document.getElementById('repairForm').submit();
    },
};

// ── Initialize on DOM ready ───────────────────────
document.addEventListener('DOMContentLoaded', () => {
    window.RepairForm.init();
});