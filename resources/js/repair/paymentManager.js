 /**
 * Payment Manager
 * Handles payment modal, add/remove payments, render lists
 */

import {
    _el, _fmt, _esc, _setText, _capitalize,
    _toast, showModal, hideModal
} from './uiHelpers.js';

import { getTotal, updateTotals } from './discountManager.js';

// ── Shared state reference ────────────────────────
let _state = null;

export function initPayment(state) {
    _state = state;
}

// ── Helpers ───────────────────────────────────────
function _getTotalPaid() {
    return _state.payments.reduce((s, p) => s + p.amount, 0);
}

function _getOutstanding() {
    return Math.max(0, getTotal() - _getTotalPaid());
}

function _methodIcon(method, splitPart) {
    const icons = {
        cash  : '💵',
        card  : '💳',
        split : splitPart === 'card' ? '💳' : '💵',
        trade : '🔄',
        other : '💰',
    };
    return icons[method] || '💰';
}

// ── Modal ─────────────────────────────────────────
export function openPaymentModal() {
    const total = getTotal();
    if (total <= 0) return;

    _setText('repair-payment-total', _fmt(total));

    const amountInput   = _el('repair-payment-amount');
    const noteInput     = _el('repair-payment-note');
    const changeDisplay = _el('repair-change-display');
    if (amountInput)   amountInput.value           = '';
    if (noteInput)     noteInput.value             = '';
    if (changeDisplay) changeDisplay.style.display = 'none';

    const cashRadio = document.querySelector(
        'input[name="repair_payment_method"][value="cash"]'
    );
    if (cashRadio) cashRadio.checked = true;
    selectMethod('cash');

    _updateModalOutstanding();
    renderExistingPayments();

    showModal('repair-payment-modal', 'repair-payment-modal-box');
    setTimeout(() => _el('repair-payment-amount')?.focus(), 200);
}

export function closePaymentModal() {
    hideModal('repair-payment-modal', 'repair-payment-modal-box');
}

export function onMethodChange(method) {
    selectMethod(method);
}

export function selectMethod(method) {
    _state.selectedMethod = method;

    ['cash', 'card', 'split', 'trade'].forEach(m => {
        const el = _el(`repair-fields-${m}`);
        if (el) el.style.display = 'none';
    });

    const active = _el(`repair-fields-${method}`);
    if (active) active.style.display = method === 'card' ? 'flex' : 'block';

    if (method === 'split') {
        const outstanding = _getOutstanding();
        const s1 = _el('repair-split1-amount');
        const s2 = _el('repair-split2-amount');
        if (s1) s1.value = '';
        if (s2) s2.value = outstanding.toFixed(2);
    }

    if (method === 'trade') {
        const ti = _el('repair-trade-value');
        if (ti) ti.value = '';
    }
}

export function setQuickAmount(amount) {
    const input = _el('repair-payment-amount');
    if (input) { input.value = amount.toFixed(2); updateChange(); }
}

export function setExactAmount() {
    const input = _el('repair-payment-amount');
    if (input) { input.value = _getOutstanding().toFixed(2); updateChange(); }
}

export function updateChange() {
    const tendered    = parseFloat(_el('repair-payment-amount')?.value) || 0;
    const outstanding = _getOutstanding();
    const change      = tendered - outstanding;
    const display     = _el('repair-change-display');
    const amount      = _el('repair-change-amount');

    if (tendered > 0 && change >= 0) {
        if (display) display.style.display = 'flex';
        if (amount)  amount.textContent     = _fmt(change);
    } else {
        if (display) display.style.display = 'none';
    }
}

export function updateSplit2() {
    const a1 = parseFloat(_el('repair-split1-amount')?.value) || 0;
    const s2 = _el('repair-split2-amount');
    if (s2) s2.value = Math.max(0, _getOutstanding() - a1).toFixed(2);
}

// ── Add Payment ───────────────────────────────────
export function addPayment() {
    const method = _state.selectedMethod;
    const note   = _el('repair-payment-note')?.value || null;

    if (method === 'split') {
        const a1 = parseFloat(_el('repair-split1-amount')?.value) || 0;
        const a2 = parseFloat(_el('repair-split2-amount')?.value) || 0;
        const m1 = _el('repair-split1-method')?.value || 'cash';
        const m2 = _el('repair-split2-method')?.value || 'card';

        if (a1 <= 0 && a2 <= 0) {
            _toast('Please enter payment amounts', 'error');
            return;
        }

        if (a1 > 0) _state.payments.push({
            method:'split', splitPart:m1, amount:a1,
            note, label:`${_capitalize(m1)} (split)`,
        });
        if (a2 > 0) _state.payments.push({
            method:'split', splitPart:m2, amount:a2,
            note:null, label:`${_capitalize(m2)} (split)`,
        });

    } else if (method === 'card') {
        const outstanding = _getOutstanding();
        if (outstanding <= 0) { _toast('No outstanding balance', 'error'); return; }
        _state.payments.push({
            method:'card', splitPart:null,
            amount:outstanding, note, label:'Card',
        });

    } else if (method === 'trade') {
        const tradeValue = parseFloat(_el('repair-trade-value')?.value) || 0;
        if (tradeValue <= 0) { _toast('Please enter a trade-in value', 'error'); return; }
        _state.payments.push({
            method:'trade', splitPart:null,
            amount: Math.min(tradeValue, _getOutstanding()),
            note: note || 'Trade-in', label:'Trade-in',
        });

    } else {
        const amount = parseFloat(_el('repair-payment-amount')?.value) || 0;
        if (amount <= 0) { _toast('Please enter an amount', 'error'); return; }
        _state.payments.push({
            method:'cash', splitPart:null,
            amount: Math.min(amount, _getOutstanding()),
            note, label:'Cash',
        });
    }

    _afterPaymentChange();

    if (_getOutstanding() <= 0) {
        closePaymentModal();
        _toast('Payment complete!', 'success');
    } else {
        const ai = _el('repair-payment-amount');
        const ni = _el('repair-payment-note');
        if (ai) ai.value = '';
        if (ni) ni.value = '';
        _toast(`Payment added — ${_fmt(_getOutstanding())} remaining`, 'success');
    }
}

export function removePayment(index) {
    _state.payments.splice(index, 1);
    _afterPaymentChange();
    _updateModalOutstanding();
    renderExistingPayments();
}

export function clearPayments() {
    _state.payments = [];
    _renderRightPanelPayments();
    _updatePaymentSummary();
    _injectPaymentInputs();
}

function _afterPaymentChange() {
    _renderRightPanelPayments();
    _updatePaymentSummary();
    _updateModalOutstanding();
    renderExistingPayments();
    _injectPaymentInputs();
}

// ── Render right panel ────────────────────────────
function _renderRightPanelPayments() {
    const section = _el('rp-payments-section');
    const list    = _el('rp-payments-list');
    if (!list) return;

    list.innerHTML = '';

    if (_state.payments.length === 0) {
        if (section) section.style.display = 'none';
        return;
    }

    if (section) section.style.display = 'block';

    _state.payments.forEach((p, i) => {
        const row     = document.createElement('div');
        row.className = 'flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-800 last:border-0 text-sm';
        row.innerHTML = `
            <div class="flex items-center gap-2 min-w-0">
                <span class="text-base">${_methodIcon(p.method, p.splitPart)}</span>
                <div class="min-w-0">
                    <p class="font-semibold text-gray-900 dark:text-white text-xs">${_esc(p.label)}</p>
                    ${p.note ? `<p class="text-xs text-gray-400 dark:text-gray-500 truncate">${_esc(p.note)}</p>` : ''}
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="font-bold text-gray-900 dark:text-white text-xs">${_fmt(p.amount)}</span>
                <button type="button"
                        data-remove-payment="${i}"
                        class="w-5 h-5 rounded-full bg-red-100 dark:bg-red-900/30
                               text-red-500 flex items-center justify-center
                               hover:bg-red-200 transition-all border-none
                               cursor-pointer text-xs">✕</button>
            </div>`;
        list.appendChild(row);
    });

    // Attach remove listeners
    list.querySelectorAll('[data-remove-payment]').forEach(btn => {
        btn.addEventListener('click', () => {
            removePayment(parseInt(btn.dataset.removePayment));
        });
    });
}

export function renderExistingPayments() {
    const section = _el('repair-existing-payments');
    const list    = _el('repair-existing-payments-list');
    if (!list) return;

    if (_state.payments.length === 0) {
        if (section) section.style.display = 'none';
        return;
    }

    if (section) section.style.display = 'block';
    list.innerHTML = '';

    _state.payments.forEach((p, i) => {
        const row     = document.createElement('div');
        row.className = 'flex items-center justify-between text-xs py-1.5 border-b border-gray-100 dark:border-gray-800 last:border-0';
        row.innerHTML = `
            <span class="text-gray-600 dark:text-gray-400 font-medium">
                ${_esc(p.label)}
                ${p.note ? `<span class="text-gray-400"> — ${_esc(p.note)}</span>` : ''}
            </span>
            <div class="flex items-center gap-1.5">
                <span class="font-bold text-gray-900 dark:text-white">${_fmt(p.amount)}</span>
                <button type="button"
                        data-remove-payment="${i}"
                        class="w-4 h-4 rounded-full bg-red-100 dark:bg-red-900/30
                               text-red-500 flex items-center justify-center
                               hover:bg-red-200 transition-all border-none
                               cursor-pointer text-xs leading-none">✕</button>
            </div>`;
        list.appendChild(row);
    });

    list.querySelectorAll('[data-remove-payment]').forEach(btn => {
        btn.addEventListener('click', () => {
            removePayment(parseInt(btn.dataset.removePayment));
        });
    });
}

function _updatePaymentSummary() {
    _setText('rp-paid',        _fmt(_getTotalPaid()));
    _setText('rp-outstanding', _fmt(_getOutstanding()));
}

function _updateModalOutstanding() {
    const outstanding = _getOutstanding();
    const row         = _el('repair-payment-outstanding-row');
    const span        = _el('repair-payment-outstanding');

    if (outstanding > 0 && _state.payments.length > 0) {
        if (row)  row.style.display = 'block';
        if (span) span.textContent  = _fmt(outstanding);
    } else {
        if (row) row.style.display = 'none';
    }
}

function _injectPaymentInputs() {
    document.querySelectorAll('.repair-payment-hidden').forEach(el => el.remove());

    const form = document.getElementById('repairForm');
    if (!form) return;

    _state.payments.forEach((p, i) => {
        const fields = {
            [`payments[${i}][method]`]    : p.method,
            [`payments[${i}][split_part]`]: p.splitPart || '',
            [`payments[${i}][amount]`]    : p.amount,
            [`payments[${i}][note]`]      : p.note || '',
        };

        Object.entries(fields).forEach(([name, value]) => {
            const input     = document.createElement('input');
            input.type      = 'hidden';
            input.name      = name;
            input.value     = value;
            input.className = 'repair-payment-hidden';
            form.appendChild(input);
        });
    });
}