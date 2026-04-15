/**
 * Discount Manager
 * Handles discount modal, type toggle, calculations
 */

import { _el, _fmt, _setText, _toast, showModal, hideModal } from './uiHelpers.js';

// ── Shared state reference (set from index.js) ────
let _state = null;

export function initDiscount(state) {
    _state = state;
}

// ── Get total after discount ──────────────────────
export function getTotal() {
    return Math.max(0, _state.subtotal - _state.discountAmount);
}

// ── Update all total displays ─────────────────────
export function updateTotals() {
    const subtotal = _calcSubtotal();
    _state.subtotal       = subtotal;
    _state.discountAmount = Math.min(_state.discountAmount, subtotal);

    const total = getTotal();

    _setText('rp-subtotal',                   _fmt(subtotal));
    _setText('rp-discount',                   '-' + _fmt(_state.discountAmount));
    _setText('rp-total',                      _fmt(total));
    _setText('rp-charge-total',               _fmt(total));
    _setText('repair-discount-subtotal-label',`Subtotal: ${_fmt(subtotal)}`);

    const chargeBtn = _el('rp-charge-btn');
    if (chargeBtn) chargeBtn.disabled = total <= 0;
}

function _calcSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('input[name$="[price]"]').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });
    return subtotal;
}

// ── Modal ─────────────────────────────────────────
export function openDiscountModal() {
    const input = _el('repair-disc-input');
    if (input) input.value = '';

    _state.discountType = 'percent';
    _syncDiscountUI();
    updateDiscountPreview();

    const removeBtn = _el('repair-disc-remove-btn');
    if (removeBtn) {
        removeBtn.style.display = _state.discountAmount > 0 ? 'block' : 'none';
    }

    showModal('repair-discount-modal', 'repair-discount-modal-box');
    setTimeout(() => _el('repair-disc-input')?.focus(), 200);
}

export function closeDiscountModal() {
    hideModal('repair-discount-modal', 'repair-discount-modal-box');
}

export function setDiscountType(type) {
    _state.discountType = type;
    _syncDiscountUI();
    updateDiscountPreview();
}

function _syncDiscountUI() {
    const pBtn   = _el('repair-disc-percent-btn');
    const fBtn   = _el('repair-disc-fixed-btn');
    const symbol = _el('repair-disc-symbol');
    const quick  = _el('repair-disc-quick-btns');

    const activeClass   = 'py-2.5 rounded-xl text-sm font-bold transition-all border-2 border-indigo-500 bg-indigo-600 text-white';
    const inactiveClass = 'py-2.5 rounded-xl text-sm font-bold transition-all border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400 hover:border-indigo-400';

    if (_state.discountType === 'percent') {
        if (pBtn)   pBtn.className      = activeClass;
        if (fBtn)   fBtn.className      = inactiveClass;
        if (symbol) symbol.textContent  = '%';
        if (quick)  quick.style.display = 'grid';
    } else {
        if (fBtn)   fBtn.className      = activeClass;
        if (pBtn)   pBtn.className      = inactiveClass;
        if (symbol) symbol.textContent  = '£';
        if (quick)  quick.style.display = 'none';
    }
}

export function setQuickDiscount(pct) {
    _state.discountType = 'percent';
    _syncDiscountUI();
    const input = _el('repair-disc-input');
    if (input) { input.value = pct; updateDiscountPreview(); }
}

export function updateDiscountPreview() {
    const val     = parseFloat(_el('repair-disc-input')?.value) || 0;
    const preview = _el('repair-disc-preview');
    const amount  = _el('repair-disc-preview-amount');

    if (val <= 0) {
        if (preview) preview.style.display = 'none';
        return;
    }

    const calculated = _state.discountType === 'percent'
        ? (_state.subtotal * val) / 100
        : val;

    if (preview) preview.style.display = 'flex';
    if (amount)  amount.textContent     = _fmt(Math.min(calculated, _state.subtotal));
}

export function applyDiscount() {
    const val = parseFloat(_el('repair-disc-input')?.value) || 0;
    if (val <= 0) { _toast('Enter a discount value', 'error'); return; }

    _state.discountAmount = Math.min(
        Math.max(0, _state.discountType === 'percent'
            ? (_state.subtotal * val) / 100
            : val),
        _state.subtotal
    );

    const discInput = document.querySelector('input[name="discount"]');
    if (discInput) discInput.value = _state.discountAmount.toFixed(2);

    const removeBtn = _el('rp-remove-discount');
    if (removeBtn) removeBtn.style.display = 'inline-flex';

    updateTotals();
    closeDiscountModal();
    _toast(`Discount ${_fmt(_state.discountAmount)} applied`, 'success');
}

export function removeDiscount() {
    _state.discountAmount = 0;

    const discInput = document.querySelector('input[name="discount"]');
    if (discInput) discInput.value = '0';

    const removeBtn = _el('rp-remove-discount');
    if (removeBtn) removeBtn.style.display = 'none';

    updateTotals();
    closeDiscountModal();
    _toast('Discount removed', 'success');
}