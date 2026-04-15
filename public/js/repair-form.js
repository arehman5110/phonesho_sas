/**
 * Repair Payment Panel
 * Handles: totals, discount modal, payment modal
 * All device/parts/issues logic moved to resources/js/repair/
 */
const RepairPayments = (() => {



    // ─────────────────────────────────────────────────────────────
    // STATE
    // ─────────────────────────────────────────────────────────────
    const state = {
        subtotal       : 0,
        discountAmount : 0,
        discountType   : 'percent',
        payments       : [],
        selectedMethod : 'cash',
    };

    // ─────────────────────────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────────────────────────
    function _el(id) {
        return document.getElementById(id);
    }

    function _fmt(amount) {
        return '£' + parseFloat(amount || 0).toFixed(2);
    }

    function _getTotal() {
        return Math.max(0, state.subtotal - state.discountAmount);
    }

    function _getTotalPaid() {
        return state.payments.reduce((s, p) => s + p.amount, 0);
    }

    function _getOutstanding() {
        return Math.max(0, _getTotal() - _getTotalPaid());
    }

    // ─────────────────────────────────────────────────────────────
    // INIT
    // ─────────────────────────────────────────────────────────────
    function init() {
        // Watch device price inputs — live update
        document.addEventListener('input', (e) => {
            if (e.target.matches('input[name$="[price]"]')) {
                updateTotals();
            }
        });

        // Watch discount input
        document.addEventListener('input', (e) => {
            if (e.target.matches('input[name="discount"]')) {
                updateTotals();
            }
        });

        // Close modals on overlay click
        _el('repair-discount-modal')?.addEventListener('click', (e) => {
            if (e.target === e.currentTarget) closeDiscountModal();
        });

        _el('repair-payment-modal')?.addEventListener('click', (e) => {
            if (e.target === e.currentTarget) closePaymentModal();
        });

        // Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeDiscountModal();
                closePaymentModal();
            }
        });

        updateTotals();
    }

    // ─────────────────────────────────────────────────────────────
    // TOTALS
    // ─────────────────────────────────────────────────────────────
    function updateTotals() {
        // Sum all device prices
        let subtotal = 0;
        document.querySelectorAll('input[name$="[price]"]').forEach(input => {
            subtotal += parseFloat(input.value) || 0;
        });

        state.subtotal = subtotal;

        // Re-cap discount if needed
        state.discountAmount = Math.min(
            state.discountAmount,
            subtotal
        );

        const total = _getTotal();

        // Update right panel
        _setText('rp-subtotal', _fmt(subtotal));
        _setText('rp-discount', '-' + _fmt(state.discountAmount));
        _setText('rp-total',    _fmt(total));
        _setText('rp-charge-total', _fmt(total));

        // Update discount label in modal
        _setText(
            'repair-discount-subtotal-label',
            `Subtotal: ${_fmt(subtotal)}`
        );

        // Enable/disable charge button
        const chargeBtn = _el('rp-charge-btn');
        if (chargeBtn) {
            chargeBtn.disabled = total <= 0;
        }

        // Update payment outstanding
        _updatePaymentSummary();
    }

    function _setText(id, text) {
        const el = _el(id);
        if (el) el.textContent = text;
    }

    // ─────────────────────────────────────────────────────────────
    // DISCOUNT MODAL
    // ─────────────────────────────────────────────────────────────
    function openDiscountModal() {
    _el('repair-disc-input').value = '';
    state.discountType = 'percent';
    _syncDiscountUI();
    updateDiscountPreview();  // ← correct name

        // Show remove button if discount already applied
        const removeBtn = _el('repair-disc-remove-btn');
        if (removeBtn) {
            removeBtn.style.display = state.discountAmount > 0
                ? 'block' : 'none';
        }

        _showModal('repair-discount-modal', 'repair-discount-modal-box');
        setTimeout(() => _el('repair-disc-input')?.focus(), 200);
    }

    function closeDiscountModal() {
        _hideModal('repair-discount-modal', 'repair-discount-modal-box');
    }

    function setDiscountType(type) {
        state.discountType = type;
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

        if (state.discountType === 'percent') {
            if (pBtn)   pBtn.className   = activeClass;
            if (fBtn)   fBtn.className   = inactiveClass;
            if (symbol) symbol.textContent = '%';
            if (quick)  quick.style.display = 'grid';
        } else {
            if (fBtn)   fBtn.className   = activeClass;
            if (pBtn)   pBtn.className   = inactiveClass;
            if (symbol) symbol.textContent = '£';
            if (quick)  quick.style.display = 'none';
        }
    }

    function setQuickDiscount(pct) {
        state.discountType = 'percent';
        _syncDiscountUI();
        const input = _el('repair-disc-input');
        if (input) {
            input.value = pct;
            updateDiscountPreview();
        }
    }

    function updateDiscountPreview() {
        const val      = parseFloat(_el('repair-disc-input')?.value) || 0;
        const preview  = _el('repair-disc-preview');
        const amount   = _el('repair-disc-preview-amount');

        if (val <= 0) {
            if (preview) preview.style.display = 'none';
            return;
        }

        const calculated = state.discountType === 'percent'
            ? (state.subtotal * val) / 100
            : val;

        const capped = Math.min(calculated, state.subtotal);

        if (preview) preview.style.display = 'flex';
        if (amount)  amount.textContent     = _fmt(capped);
    }

    function applyDiscount() {
        const val = parseFloat(_el('repair-disc-input')?.value) || 0;

        if (val <= 0) {
            _toast('Enter a discount value', 'error');
            return;
        }

        state.discountAmount = state.discountType === 'percent'
            ? (state.subtotal * val) / 100
            : val;

        state.discountAmount = Math.min(
            Math.max(0, state.discountAmount),
            state.subtotal
        );

        // Update hidden discount input in form
        const discInput = document.querySelector('input[name="discount"]');
        if (discInput) discInput.value = state.discountAmount.toFixed(2);

        // Show remove button in right panel
        const removeBtn = _el('rp-remove-discount');
        if (removeBtn) removeBtn.style.display = 'inline-flex';

        updateTotals();
        closeDiscountModal();
        _toast(`Discount ${_fmt(state.discountAmount)} applied`, 'success');
    }

    function removeDiscount() {
        state.discountAmount = 0;

        const discInput = document.querySelector('input[name="discount"]');
        if (discInput) discInput.value = '0';

        const removeBtn = _el('rp-remove-discount');
        if (removeBtn) removeBtn.style.display = 'none';

        updateTotals();
        closeDiscountModal();
        _toast('Discount removed', 'success');
    }

    // ─────────────────────────────────────────────────────────────
    // PAYMENT MODAL
    // ─────────────────────────────────────────────────────────────
    function openPaymentModal() {
        const total = _getTotal();
        if (total <= 0) return;

        // Reset fields
        _setText('repair-payment-total', _fmt(total));

        const amountInput = _el('repair-payment-amount');
        if (amountInput) amountInput.value = '';

        const noteInput = _el('repair-payment-note');
        if (noteInput) noteInput.value = '';

        const changeDisplay = _el('repair-change-display');
        if (changeDisplay) changeDisplay.style.display = 'none';

        // Reset to cash
        const cashRadio = document.querySelector(
            'input[name="repair_payment_method"][value="cash"]'
        );
        if (cashRadio) cashRadio.checked = true;
        selectMethod('cash');

        // Show outstanding
        _updateModalOutstanding();

        // Show existing payments
        _renderExistingPayments();

        _showModal('repair-payment-modal', 'repair-payment-modal-box');
        setTimeout(() => _el('repair-payment-amount')?.focus(), 200);
    }

    function closePaymentModal() {
        _hideModal('repair-payment-modal', 'repair-payment-modal-box');
    }

    function onMethodChange(method) {
        selectMethod(method);
    }

    function selectMethod(method) {
        state.selectedMethod = method;

        const fields = ['cash', 'card', 'split'];
        fields.forEach(m => {
            const el = _el(`repair-fields-${m}`);
            if (el) el.style.display = 'none';
        });

        const active = _el(`repair-fields-${method}`);
        if (active) {
            active.style.display = method === 'card' ? 'flex' : 'block';
        }

        // Auto fill split
        if (method === 'split') {
            const outstanding = _getOutstanding();
            const split2 = _el('repair-split2-amount');
            if (split2) split2.value = outstanding.toFixed(2);
            const split1 = _el('repair-split1-amount');
            if (split1) split1.value = '';
        }
    }

    function setQuickAmount(amount) {
        const input = _el('repair-payment-amount');
        if (input) {
            input.value = amount.toFixed(2);
            updateChange();
        }
    }

    function setExactAmount() {
        const outstanding = _getOutstanding();
        const input = _el('repair-payment-amount');
        if (input) {
            input.value = outstanding.toFixed(2);
            updateChange();
        }
    }

    function updateChange() {
        const tendered  = parseFloat(_el('repair-payment-amount')?.value) || 0;
        const outstanding = _getOutstanding();
        const change    = tendered - outstanding;
        const display   = _el('repair-change-display');
        const amount    = _el('repair-change-amount');

        if (tendered > 0 && change >= 0) {
            if (display) display.style.display = 'flex';
            if (amount)  amount.textContent     = _fmt(change);
        } else {
            if (display) display.style.display = 'none';
        }
    }

    function updateSplit2() {
        const amount1     = parseFloat(_el('repair-split1-amount')?.value) || 0;
        const outstanding = _getOutstanding();
        const remainder   = Math.max(0, outstanding - amount1);
        const split2      = _el('repair-split2-amount');
        if (split2) split2.value = remainder.toFixed(2);
    }

    // ─────────────────────────────────────────────────────────────
    // ADD PAYMENT
    // ─────────────────────────────────────────────────────────────
    function addPayment() {
        const method = state.selectedMethod;
        const note   = _el('repair-payment-note')?.value || null;

        if (method === 'split') {
            const amount1  = parseFloat(_el('repair-split1-amount')?.value) || 0;
            const amount2  = parseFloat(_el('repair-split2-amount')?.value) || 0;
            const method1  = _el('repair-split1-method')?.value || 'cash';
            const method2  = _el('repair-split2-method')?.value || 'card';

            if (amount1 <= 0 && amount2 <= 0) {
                _toast('Please enter payment amounts', 'error');
                return;
            }

            if (amount1 > 0) {
                state.payments.push({
                    method    : 'split',
                    splitPart : method1,
                    amount    : amount1,
                    note      : note,
                    label     : `${_capitalize(method1)} (split)`,
                });
            }

            if (amount2 > 0) {
                state.payments.push({
                    method    : 'split',
                    splitPart : method2,
                    amount    : amount2,
                    note      : null,
                    label     : `${_capitalize(method2)} (split)`,
                });
            }

        } else if (method === 'card') {
            // Card — use outstanding amount
            const outstanding = _getOutstanding();
            if (outstanding <= 0) {
                _toast('No outstanding balance', 'error');
                return;
            }

            state.payments.push({
                method    : 'card',
                splitPart : null,
                amount    : outstanding,
                note      : note,
                label     : 'Card',
            });

        } else {
            // Cash
            const amount = parseFloat(_el('repair-payment-amount')?.value) || 0;
            if (amount <= 0) {
                _toast('Please enter an amount', 'error');
                return;
            }

            // Cap at outstanding
            const capped = Math.min(amount, _getOutstanding());

            state.payments.push({
                method    : 'cash',
                splitPart : null,
                amount    : capped,
                note      : note,
                label     : 'Cash',
            });
        }

        // Update UI
        _renderRightPanelPayments();
        _updatePaymentSummary();
        _updateModalOutstanding();
        _renderExistingPayments();
        _injectPaymentInputs();

        // Close if fully paid
        if (_getOutstanding() <= 0) {
            closePaymentModal();
            _toast('Payment complete!', 'success');
        } else {
            // Reset amount fields for next payment
            const amountInput = _el('repair-payment-amount');
            if (amountInput) amountInput.value = '';
            const noteInput = _el('repair-payment-note');
            if (noteInput) noteInput.value = '';
            _toast(`Payment added — ${_fmt(_getOutstanding())} remaining`, 'success');
        }
    }

    function clearPayments() {
        state.payments = [];
        _renderRightPanelPayments();
        _updatePaymentSummary();
        _injectPaymentInputs();
    }

    // ─────────────────────────────────────────────────────────────
    // RENDER PAYMENTS IN RIGHT PANEL
    // ─────────────────────────────────────────────────────────────
    function _renderRightPanelPayments() {
        const section = _el('rp-payments-section');
        const list    = _el('rp-payments-list');

        if (!list) return;

        list.innerHTML = '';

        if (state.payments.length === 0) {
            if (section) section.style.display = 'none';
            return;
        }

        if (section) section.style.display = 'block';

        state.payments.forEach((p, i) => {
            const row       = document.createElement('div');
            row.className   = `flex items-center justify-between
                               py-2 border-b border-gray-100
                               dark:border-gray-800 last:border-0 text-sm`;
            row.innerHTML   = `
                <div class="flex items-center gap-2 min-w-0">
                    <span class="text-base">${_methodIcon(p.method, p.splitPart)}</span>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900
                                   dark:text-white text-xs">
                            ${_esc(p.label)}
                        </p>
                        ${p.note
                            ? `<p class="text-xs text-gray-400
                                        dark:text-gray-500 truncate">
                                   ${_esc(p.note)}
                               </p>`
                            : ''}
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="font-bold text-gray-900
                                 dark:text-white text-xs">
                        ${_fmt(p.amount)}
                    </span>
                    <button type="button"
                            onclick="RepairPayments.removePayment(${i})"
                            class="w-5 h-5 rounded-full bg-red-100
                                   dark:bg-red-900/30 text-red-500
                                   flex items-center justify-center
                                   hover:bg-red-200 transition-all
                                   border-none cursor-pointer text-xs">
                        ✕
                    </button>
                </div>`;
            list.appendChild(row);
        });
    }

    function _renderExistingPayments() {
        const section = _el('repair-existing-payments');
        const list    = _el('repair-existing-payments-list');
        if (!list) return;

        if (state.payments.length === 0) {
            if (section) section.style.display = 'none';
            return;
        }

        if (section) section.style.display = 'block';
        list.innerHTML = '';

        state.payments.forEach((p, i) => {
            const row       = document.createElement('div');
            row.className   = `flex items-center justify-between
                               text-xs py-1.5 border-b
                               border-gray-100 dark:border-gray-800
                               last:border-0`;
            row.innerHTML   = `
                <span class="text-gray-600 dark:text-gray-400 font-medium">
                    ${_esc(p.label)}
                    ${p.note ? `<span class="text-gray-400"> — ${_esc(p.note)}</span>` : ''}
                </span>
                <div class="flex items-center gap-1.5">
                    <span class="font-bold text-gray-900 dark:text-white">
                        ${_fmt(p.amount)}
                    </span>
                    <button type="button"
                            onclick="RepairPayments.removePayment(${i})"
                            class="w-4 h-4 rounded-full bg-red-100
                                   dark:bg-red-900/30 text-red-500
                                   flex items-center justify-center
                                   hover:bg-red-200 transition-all
                                   border-none cursor-pointer
                                   text-xs leading-none">
                        ✕
                    </button>
                </div>`;
            list.appendChild(row);
        });
    }

    function removePayment(index) {
        state.payments.splice(index, 1);
        _renderRightPanelPayments();
        _renderExistingPayments();
        _updatePaymentSummary();
        _updateModalOutstanding();
        _injectPaymentInputs();
    }

    function _updatePaymentSummary() {
        const paid        = _getTotalPaid();
        const outstanding = _getOutstanding();

        _setText('rp-paid',        _fmt(paid));
        _setText('rp-outstanding', _fmt(outstanding));
    }

    function _updateModalOutstanding() {
        const outstanding = _getOutstanding();
        const row         = _el('repair-payment-outstanding-row');
        const span        = _el('repair-payment-outstanding');

        if (outstanding > 0 && state.payments.length > 0) {
            if (row)  row.style.display  = 'block';
            if (span) span.textContent   = _fmt(outstanding);
        } else {
            if (row) row.style.display = 'none';
        }
    }

    // ─────────────────────────────────────────────────────────────
    // INJECT HIDDEN PAYMENT INPUTS INTO FORM
    // ─────────────────────────────────────────────────────────────
    function _injectPaymentInputs() {
        // Remove existing payment inputs
        document.querySelectorAll('.repair-payment-hidden')
            .forEach(el => el.remove());

        const form = document.getElementById('repairForm');
        if (!form) return;

        state.payments.forEach((p, i) => {
            const fields = {
                [`payments[${i}][method]`]     : p.method,
                [`payments[${i}][split_part]`] : p.splitPart || '',
                [`payments[${i}][amount]`]      : p.amount,
                [`payments[${i}][note]`]        : p.note || '',
            };

            Object.entries(fields).forEach(([name, value]) => {
                const input       = document.createElement('input');
                input.type        = 'hidden';
                input.name        = name;
                input.value       = value;
                input.className   = 'repair-payment-hidden';
                form.appendChild(input);
            });
        });
    }

    // ─────────────────────────────────────────────────────────────
    // MODAL HELPERS
    // ─────────────────────────────────────────────────────────────
    function _showModal(modalId, boxId) {
        const modal = _el(modalId);
        const box   = _el(boxId);
        if (!modal || !box) return;
        modal.style.display = 'flex';
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                box.style.transform = 'scale(1)';
                box.style.opacity   = '1';
            });
        });
    }

    function _hideModal(modalId, boxId) {
        const modal = _el(modalId);
        const box   = _el(boxId);
        if (!modal || !box) return;
        box.style.transform = 'scale(0.95)';
        box.style.opacity   = '0';
        setTimeout(() => modal.style.display = 'none', 180);
    }

    // ─────────────────────────────────────────────────────────────
    // TOAST
    // ─────────────────────────────────────────────────────────────
    function _toast(message, type = 'success') {
        const existing = document.getElementById('repair-toast');
        if (existing) existing.remove();

        const colors = {
            success : '#10b981',
            error   : '#ef4444',
            warning : '#f59e0b',
        };

        const el        = document.createElement('div');
        el.id           = 'repair-toast';
        el.style.cssText = `
            position:fixed;bottom:24px;right:24px;z-index:9999;
            padding:10px 18px;border-radius:12px;color:#fff;
            font-size:0.85rem;font-weight:700;max-width:300px;
            box-shadow:0 8px 24px rgba(0,0,0,0.15);
            background:${colors[type] || colors.success};
            transform:translateY(10px);opacity:0;
            transition:all 0.25s ease;`;
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
    }

    // ─────────────────────────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────────────────────────
    function _methodIcon(method, splitPart) {
        const icons = {
            cash  : '💵',
            card  : '💳',
            split : splitPart === 'card' ? '💳' : '💵',
            other : '💰',
        };
        return icons[method] || '💰';
    }

    function _capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function _esc(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = String(str);
        return d.innerHTML;
    }

    // ─────────────────────────────────────────────────────────────
// WARRANTY EXPIRY CALCULATOR
// ─────────────────────────────────────────────────────────────
function updateWarrantyExpiry(input) {
    const days = parseInt(input.value) || 0;

    // Find the expiry display field in the same device card
    const card = input.closest('.device-card');
    if (!card) return;

    const expiryInput = card.querySelector('[data-warranty-expiry]');
    if (!expiryInput) return;

    if (days <= 0) {
        expiryInput.value       = '';
        expiryInput.placeholder = 'Enter warranty days →';
        return;
    }

    // Calculate expiry date
    const expiry = new Date();
    expiry.setDate(expiry.getDate() + days);

    // Format as dd/mm/yyyy
    const formatted = expiry.toLocaleDateString('en-GB', {
        day   : '2-digit',
        month : 'short',
        year  : 'numeric',
    });

    expiryInput.value = formatted;
}

    // ─────────────────────────────────────────────────────────────
    // PUBLIC API
    // ─────────────────────────────────────────────────────────────
    return {
        init,
        updateTotals,
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

})();



document.addEventListener('DOMContentLoaded', () => RepairPayments.init());